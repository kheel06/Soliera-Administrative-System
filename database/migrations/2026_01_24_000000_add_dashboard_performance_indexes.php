<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Adds indexes to optimize dashboard metric queries.
     * All indexes are designed for the specific query patterns in DashboardMetricsService.
     */
    public function __construct()
    {
        // Register enum type to prevent Doctrine errors during table introspection
        try {
            \Illuminate\Support\Facades\DB::getDoctrineSchemaManager()
                ->getDatabasePlatform()
                ->registerDoctrineTypeMapping('enum', 'string');
        } catch (\Throwable $e) {
            // Ignore if already registered or if connection fails
        }
    }

    public function up(): void
    {
        // Visitor table indexes for time_in queries
        Schema::table('visitor', function (Blueprint $table) {
            // Index for visitors today query: whereDate('time_in', ...)
            if (!$this->indexExists('visitor', 'idx_visitor_time_in')) {
                $table->index('time_in', 'idx_visitor_time_in');
            }
        });

        // Documents table indexes for status and archived_at queries
        Schema::table('documents', function (Blueprint $table) {
            // Index for archived documents query
            if (!$this->indexExists('documents', 'idx_documents_status')) {
                $table->index('status', 'idx_documents_status');
            }
            
            // Index for archived_at queries
            if (!$this->indexExists('documents', 'idx_documents_archived_at')) {
                $table->index('archived_at', 'idx_documents_archived_at');
            }
            
            // Composite index for total documents query (status + archived_at)
            if (!$this->indexExists('documents', 'idx_documents_status_archived')) {
                $table->index(['status', 'archived_at'], 'idx_documents_status_archived');
            }
            
            // Index for created_at (document throughput queries)
            if (!$this->indexExists('documents', 'idx_documents_created_at')) {
                $table->index('created_at', 'idx_documents_created_at');
            }
        });

        // Facility reservations table indexes
        Schema::table('facility_reservations', function (Blueprint $table) {
            // Index for facility_id (top facilities query)
            if (!$this->indexExists('facility_reservations', 'idx_facility_reservations_facility_id')) {
                $table->index('facility_id', 'idx_facility_reservations_facility_id');
            }
            
            // Index for created_at
            if (!$this->indexExists('facility_reservations', 'idx_facility_reservations_created_at')) {
                $table->index('created_at', 'idx_facility_reservations_created_at');
            }
        });

        // Legal cases table indexes for status queries
        Schema::table('legal_cases', function (Blueprint $table) {
            // Index for status (legal cases by status query)
            if (!$this->indexExists('legal_cases', 'idx_legal_cases_status')) {
                $table->index('status', 'idx_legal_cases_status');
            }
            
            // Index for created_at (case aging queries)
            if (!$this->indexExists('legal_cases', 'idx_legal_cases_created_at')) {
                $table->index('created_at', 'idx_legal_cases_created_at');
            }
            
            // Index for resolved_at (completed case aging)
            if (!$this->indexExists('legal_cases', 'idx_legal_cases_resolved_at')) {
                $table->index('resolved_at', 'idx_legal_cases_resolved_at');
            }
        });

        // Department accounts table index for status
        Schema::table('department_accounts', function (Blueprint $table) {
            // Index for status (active accounts query)
            if (!$this->indexExists('department_accounts', 'idx_department_accounts_status')) {
                $table->index('status', 'idx_department_accounts_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor', function (Blueprint $table) {
            $table->dropIndex('idx_visitor_time_in');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropIndex('idx_documents_status');
            $table->dropIndex('idx_documents_archived_at');
            $table->dropIndex('idx_documents_status_archived');
            $table->dropIndex('idx_documents_created_at');
        });

        Schema::table('facility_reservations', function (Blueprint $table) {
            $table->dropIndex('idx_facility_reservations_facility_id');
            $table->dropIndex('idx_facility_reservations_created_at');
        });

        Schema::table('legal_cases', function (Blueprint $table) {
            $table->dropIndex('idx_legal_cases_status');
            $table->dropIndex('idx_legal_cases_created_at');
            $table->dropIndex('idx_legal_cases_resolved_at');
        });

        Schema::table('department_accounts', function (Blueprint $table) {
            $table->dropIndex('idx_department_accounts_status');
        });
    }

    /**
     * Check if an index exists on a table
     * 
     * @param string $table
     * @param string $index
     * @return bool
     */
    private function indexExists(string $table, string $index): bool
    {
        $connection = Schema::getConnection();
        $doctrineSchemaManager = $connection->getDoctrineSchemaManager();
        $doctrineTable = $doctrineSchemaManager->listTableDetails($table);
        
        return $doctrineTable->hasIndex($index);
    }
};
