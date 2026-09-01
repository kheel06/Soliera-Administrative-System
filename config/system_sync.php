<?php

return [
    /*
    |--------------------------------------------------------------------------
    | System Sync Configuration
    |--------------------------------------------------------------------------
    |
    | This config controls which tables can be synced and how the sync API
    | is authenticated. Use SYSTEM_SYNC_TOKEN for a shared token if you want
    | Syncronizr (or any external sync agent) to access the API without
    | creating a Sanctum token.
    |
    */

    'token' => env('SYSTEM_SYNC_TOKEN', env('API_BEARER_TOKEN')),

    // Comma-separated list of tables to allow. Empty means "allow all".
    'allowed_tables' => array_filter(array_map('trim', explode(',', env('SYSTEM_SYNC_ALLOWED_TABLES', '')))),

    // Comma-separated list of tables to exclude.
    'excluded_tables' => array_filter(array_map('trim', explode(',', env('SYSTEM_SYNC_EXCLUDED_TABLES', 'migrations,failed_jobs,password_reset_tokens,personal_access_tokens,sessions,cache,cache_locks,job_batches')))),

    'max_limit' => (int) env('SYSTEM_SYNC_MAX_LIMIT', 1000),

    'max_import_records' => (int) env('SYSTEM_SYNC_MAX_IMPORT_RECORDS', 1000),
];
