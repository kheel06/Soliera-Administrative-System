<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SystemDataController extends Controller
{
    /**
     * List all tables in the database.
     */
    public function getTables(Request $request)
    {
        $tables = $this->getFilteredTables();
        $include = $this->parseInclude($request->input('include'));

        $includeCounts = in_array('counts', $include, true) || in_array('count', $include, true);
        $includeColumns = in_array('columns', $include, true) || in_array('schema', $include, true);
        $includeKeys = in_array('keys', $include, true) || in_array('primary_key', $include, true);
        $includeTimestamps = in_array('timestamps', $include, true);

        $tablesWithMeta = [];
        foreach ($tables as $table) {
            $entry = ['name' => $table];

            if ($includeCounts) {
                $entry['count'] = DB::table($table)->count();
            }
            if ($includeColumns) {
                $entry['columns'] = Schema::getColumnListing($table);
            }
            if ($includeKeys) {
                $entry['primary_key'] = $this->getPrimaryKeyColumns($table);
            }
            if ($includeTimestamps) {
                $entry['timestamps'] = $this->getTimestampColumns($table);
            }

            $tablesWithMeta[] = $entry;
        }

        return response()->json([
            'success' => true,
            'tables' => $tablesWithMeta,
            'count' => count($tablesWithMeta),
            'generated_at' => now()->toISOString(),
        ]);
    }

    /**
     * Get data for a specific table.
     */
    public function getTableData(Request $request, string $table)
    {
        if (!$this->isTableAllowed($table)) {
            return response()->json([
                'success' => false,
                'message' => "Table '{$table}' not found or not allowed."
            ], 404);
        }

        $limit = (int) $request->input('limit', 100);
        $maxLimit = (int) config('system_sync.max_limit', 1000);
        $limit = max(1, min($limit, $maxLimit));

        $mode = strtolower((string) $request->input('mode', 'paginate'));
        if ($mode === 'paginate') {
            $data = DB::table($table)->paginate($limit);
            return response()->json($data);
        }

        $columns = Schema::getColumnListing($table);
        $orderBy = (string) $request->input('order_by', '');
        $direction = strtolower((string) $request->input('order_dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $cursor = $request->input('cursor');
        $since = $request->input('since');
        $offset = (int) $request->input('offset', 0);

        if ($orderBy === '') {
            $primaryKey = $this->getPrimaryKeyColumns($table);
            $orderBy = $primaryKey[0] ?? $columns[0] ?? 'id';
        }

        if (!in_array($orderBy, $columns, true)) {
            return response()->json([
                'success' => false,
                'message' => "Invalid order_by column '{$orderBy}'."
            ], 422);
        }

        $query = DB::table($table);

        if ($since) {
            $timestampColumn = $this->getPreferredTimestampColumn($columns);
            if ($timestampColumn) {
                $query->where($timestampColumn, '>=', $since);
            }
        }

        if ($cursor !== null && $cursor !== '') {
            $operator = $direction === 'asc' ? '>' : '<';
            $query->where($orderBy, $operator, $cursor);
        } elseif ($offset > 0) {
            $query->offset($offset);
        }

        $rows = $query->orderBy($orderBy, $direction)
            ->limit($limit)
            ->get();

        $nextCursor = null;
        if ($rows->count() > 0) {
            $last = $rows->last();
            if (is_object($last) && isset($last->{$orderBy})) {
                $nextCursor = $last->{$orderBy};
            }
        }

        return response()->json([
            'success' => true,
            'table' => $table,
            'count' => $rows->count(),
            'limit' => $limit,
            'order_by' => $orderBy,
            'order_dir' => $direction,
            'cursor' => $cursor,
            'next_cursor' => $nextCursor,
            'data' => $rows,
        ]);
    }

    /**
     * Import data into a specific table (bulk upsert/insert).
     */
    public function importTableData(Request $request, string $table)
    {
        if (!$this->isTableAllowed($table)) {
            return response()->json([
                'success' => false,
                'message' => "Table '{$table}' not found or not allowed."
            ], 404);
        }

        $validated = $request->validate([
            'records' => 'required|array|min:1',
            'records.*' => 'array',
            'unique_by' => 'nullable',
            'mode' => 'nullable|string|in:upsert,insert',
        ]);

        $maxRecords = (int) config('system_sync.max_import_records', 1000);
        if (count($validated['records']) > $maxRecords) {
            return response()->json([
                'success' => false,
                'message' => "Too many records. Max allowed per request is {$maxRecords}.",
            ], 422);
        }

        $columns = Schema::getColumnListing($table);
        $records = $this->filterRecordsToColumns($validated['records'], $columns);

        if (empty($records)) {
            return response()->json([
                'success' => false,
                'message' => 'No valid records to import.',
            ], 422);
        }

        $uniqueBy = $this->normalizeUniqueBy($validated['unique_by'] ?? null);
        if (empty($uniqueBy)) {
            $uniqueBy = $this->getPrimaryKeyColumns($table);
        }

        $uniqueBy = array_values(array_intersect($uniqueBy, $columns));

        $mode = strtolower((string) ($validated['mode'] ?? 'upsert'));
        $affected = 0;

        if ($mode === 'insert' || empty($uniqueBy)) {
            $affected = DB::table($table)->insert($records) ? count($records) : 0;
        } else {
            $updateColumns = array_values(array_diff($columns, $uniqueBy));
            $affected = DB::table($table)->upsert($records, $uniqueBy, $updateColumns);
        }

        return response()->json([
            'success' => true,
            'table' => $table,
            'mode' => $mode,
            'records_received' => count($records),
            'records_affected' => $affected,
        ]);
    }

    protected function parseInclude(?string $include): array
    {
        if (!$include) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $include))));
    }

    protected function getFilteredTables(): array
    {
        $tables = $this->listTableNames();

        $allowed = config('system_sync.allowed_tables', []);
        $excluded = config('system_sync.excluded_tables', []);

        $tables = array_values(array_filter($tables, function ($table) use ($allowed, $excluded) {
            if (!empty($allowed) && !in_array($table, $allowed, true)) {
                return false;
            }
            if (!empty($excluded) && in_array($table, $excluded, true)) {
                return false;
            }
            return true;
        }));

        sort($tables);

        return $tables;
    }

    protected function isTableAllowed(string $table): bool
    {
        if (!Schema::hasTable($table)) {
            return false;
        }

        $allowed = config('system_sync.allowed_tables', []);
        $excluded = config('system_sync.excluded_tables', []);

        if (!empty($allowed) && !in_array($table, $allowed, true)) {
            return false;
        }
        if (!empty($excluded) && in_array($table, $excluded, true)) {
            return false;
        }

        return true;
    }

    protected function listTableNames(): array
    {
        try {
            return DB::connection()->getDoctrineSchemaManager()->listTableNames();
        } catch (\Throwable $e) {
            // Fallback for environments without doctrine/dbal.
        }

        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            $rows = DB::select('SHOW TABLES');
            return $this->flattenTableList($rows);
        }

        if ($driver === 'sqlite') {
            $rows = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            return $this->flattenTableList($rows);
        }

        if ($driver === 'pgsql') {
            $rows = DB::select("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname = 'public'");
            return $this->flattenTableList($rows);
        }

        if ($driver === 'sqlsrv') {
            $rows = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'");
            return $this->flattenTableList($rows);
        }

        return [];
    }

    protected function flattenTableList(array $rows): array
    {
        $tables = [];
        foreach ($rows as $row) {
            $values = array_values((array) $row);
            if (!empty($values)) {
                $tables[] = $values[0];
            }
        }
        return $tables;
    }

    protected function getPrimaryKeyColumns(string $table): array
    {
        try {
            $schema = DB::connection()->getDoctrineSchemaManager();
            $details = $schema->listTableDetails($table);
            $primaryKey = $details->getPrimaryKey();
            if ($primaryKey) {
                return $primaryKey->getColumns();
            }
        } catch (\Throwable $e) {
            // Fallback below.
        }

        try {
            $rows = DB::select("SHOW KEYS FROM `{$table}` WHERE Key_name = 'PRIMARY'");
            $columns = [];
            foreach ($rows as $row) {
                if (!empty($row->Column_name)) {
                    $columns[] = $row->Column_name;
                }
            }
            return $columns;
        } catch (\Throwable $e) {
            return [];
        }
    }

    protected function getTimestampColumns(string $table): array
    {
        $columns = Schema::getColumnListing($table);
        $timestamps = [];
        foreach (['created_at', 'updated_at', 'deleted_at'] as $col) {
            if (in_array($col, $columns, true)) {
                $timestamps[] = $col;
            }
        }
        return $timestamps;
    }

    protected function getPreferredTimestampColumn(array $columns): ?string
    {
        if (in_array('updated_at', $columns, true)) {
            return 'updated_at';
        }
        if (in_array('created_at', $columns, true)) {
            return 'created_at';
        }
        return null;
    }

    protected function normalizeUniqueBy($uniqueBy): array
    {
        if (is_string($uniqueBy)) {
            return array_values(array_filter(array_map('trim', explode(',', $uniqueBy))));
        }
        if (is_array($uniqueBy)) {
            return array_values(array_filter(array_map('trim', $uniqueBy)));
        }
        return [];
    }

    protected function filterRecordsToColumns(array $records, array $columns): array
    {
        $allowed = array_flip($columns);
        $filtered = [];
        foreach ($records as $record) {
            if (!is_array($record)) {
                continue;
            }
            $row = array_intersect_key($record, $allowed);
            if (!empty($row)) {
                $filtered[] = $row;
            }
        }
        return $filtered;
    }
}
