# Admin Dashboard Metrics Guide

## Overview

This document provides comprehensive documentation for the Admin Dashboard metrics system, including metric definitions, data sources, extension guidelines, and operational procedures.

**System**: Hotel & Restaurant Administrative Management System  
**Framework**: Laravel 10.x  
**Timezone**: Asia/Manila  
**Last Updated**: 2026-01-24

---

## Architecture

### Components

1. **DashboardMetricsService** (`app/Services/DashboardMetricsService.php`)
   - Centralized metric calculation logic
   - Timezone-safe queries
   - Caching support
   - Additional analytics methods

2. **AdminDashboardController** (`app/Http/Controllers/Api/AdminDashboardController.php`)
   - API endpoint for metrics
   - RBAC enforcement
   - Error handling and logging

3. **Database Indexes** (`database/migrations/2026_01_24_000000_add_dashboard_performance_indexes.php`)
   - Optimized indexes for dashboard queries
   - Covers all metric query patterns

4. **Unit Tests** (`tests/Unit/DashboardMetricsServiceTest.php`)
   - Comprehensive test coverage
   - Timezone boundary testing
   - Zero-fill validation

---

## Metric Definitions

### 1. Visitors Today

**Definition**: Count of visitor check-ins where `time_in` falls within today's date boundaries (Asia/Manila timezone).

**Query Logic**:
```php
$todayStart = Carbon::now('Asia/Manila')->startOfDay();
$todayEnd = Carbon::now('Asia/Manila')->endOfDay();
Visitor::whereBetween('time_in', [$todayStart, $todayEnd])->count();
```

**Data Source**:
- Table: `visitor`
- Field: `time_in` (datetime)

**Exclusions**: None (all check-ins count regardless of checkout status)

**Edge Cases**:
- Timezone boundaries are handled correctly
- Visitors who checked in but haven't checked out are counted
- Pre-scheduled visitors are only counted when they actually check in

---

### 2. Archived Documents

**Definition**: Count of documents with `status='archived'` OR `archived_at IS NOT NULL`.

**Query Logic**:
```php
Document::where(function ($query) {
    $query->where('status', 'archived')
          ->orWhereNotNull('archived_at');
})->count();
```

**Data Source**:
- Table: `documents`
- Fields: `status` (varchar), `archived_at` (datetime)

**Exclusions**: None (archived means archived regardless of other fields)

**Rationale**: Documents can be marked as archived via status field OR by setting archived_at timestamp. Both methods are valid.

---

### 3. Total Documents

**Definition**: Count of all non-archived, non-disposed documents representing active/available documents in the system.

**Query Logic**:
```php
Document::whereNotIn('status', ['archived', 'disposed', 'expired'])
    ->whereNull('archived_at')
    ->count();
```

**Data Source**:
- Table: `documents`
- Fields: `status` (varchar), `archived_at` (datetime)

**Exclusions**:
- `status` IN ('archived', 'disposed', 'expired')
- `archived_at` IS NOT NULL

**Rationale**: "Total Documents" should represent documents that are actively available in the system, not historical/archived records.

---

### 4. Total Reservations

**Definition**: Count of all facility reservations (lifetime total).

**Query Logic**:
```php
FacilityReservation::count();
```

**Data Source**:
- Table: `facility_reservations`

**Exclusions**: None (all reservations count including cancelled for historical tracking)

**Rationale**: Provides overall system usage metric. Alternative interpretations considered:
- Today's reservations: too volatile for KPI card
- Upcoming reservations: less useful for admin overview

---

### 5. Active Accounts

**Definition**: Count of department accounts with `status='active'`.

**Query Logic**:
```php
DeptAccount::where('status', 'active')->count();
```

**Data Source**:
- Table: `department_accounts`
- Field: `status` (varchar)

**Exclusions**: `status != 'active'`

**Note**: System uses `DeptAccount` model (not `User`) for authentication as configured in `config/auth.php`.

---

### 6. Visitor Trend (Last 7 Days)

**Definition**: Daily visitor check-in counts for the last 7 days (including today), zero-filled to ensure all 7 days are present.

**Query Logic**:
```php
for ($i = 6; $i >= 0; $i--) {
    $date = Carbon::now('Asia/Manila')->subDays($i);
    $count = Visitor::whereDate('time_in', $date->toDateString())->count();
    // ... build series
}
```

**Data Source**:
- Table: `visitor`
- Field: `time_in` (datetime)

**Return Format**:
```json
[
  {"date": "2026-01-18", "label": "Mon", "count": 5},
  {"date": "2026-01-19", "label": "Tue", "count": 0},
  ...
  {"date": "2026-01-24", "label": "Sat", "count": 12}
]
```

**Features**:
- Zero-filled (days with no visitors show count: 0)
- Timezone-safe (uses Asia/Manila)
- Ordered chronologically (oldest to newest)

---

### 7. Legal Cases by Status

**Definition**: Count of legal cases grouped into 3 operational categories with robust status mapping.

**Status Mapping**:

| Dashboard Category | Database Status Values |
|-------------------|------------------------|
| **Pending** | `pending` |
| **In Progress** | `under_investigation`, `awaiting_review`, `needs_more_info`, `ongoing` |
| **Completed** | `resolved`, `completed`, `closed` |

**Query Logic**:
```php
$statusCounts = LegalCase::select('status', DB::raw('COUNT(*) as count'))
    ->groupBy('status')
    ->pluck('count', 'status')
    ->toArray();

// Map to dashboard categories
$pending = $statusCounts['pending'] ?? 0;
$inProgress = ($statusCounts['under_investigation'] ?? 0) + ...;
$completed = ($statusCounts['resolved'] ?? 0) + ...;
```

**Data Source**:
- Table: `legal_cases`
- Field: `status` (varchar - changed from enum in migration 2026_01_22_134056)

**Exclusions**: 
- `status = 'not_approved'` or `'rejected'` (not counted in any category)

**Extensibility**: If new status values are added to the system, update the mapping in `getLegalCasesByStatus()` method.

---

## Additional Analytics

### Legal Case Aging

**Definition**: Median days since creation per status category.

**Method**: `getLegalCaseAging()`

**Return Format**:
```json
{
  "pending": 7.5,
  "in_progress": 12.0,
  "completed": 45.0
}
```

**Use Case**: Identify bottlenecks in legal case processing.

---

### Top Facilities

**Definition**: Top N facilities by reservation count.

**Method**: `getTopFacilities(int $limit = 5)`

**Return Format**:
```json
[
  {"facility_id": 1, "facility_name": "Conference Room A", "count": 45},
  {"facility_id": 3, "facility_name": "Banquet Hall", "count": 32},
  ...
]
```

**Use Case**: Resource allocation and facility utilization analysis.

---

### Document Throughput

**Definition**: Document creation and archival metrics.

**Method**: `getDocumentThroughput()`

**Return Format**:
```json
{
  "last_7_days": 15,
  "last_30_days": 67,
  "archival_rate": 23.5
}
```

**Use Case**: Document lifecycle management and compliance tracking.

---

## API Endpoints

### GET /api/admin/dashboard/metrics

**Description**: Get all dashboard metrics in a single call.

**Authentication**: Required (`auth:sanctum` middleware)

**Query Parameters**:
- `cache` (optional, default: `true`): Enable/disable caching
- `cache_ttl` (optional, default: `60`): Cache TTL in seconds

**Response**:
```json
{
  "success": true,
  "data": {
    "kpis": {
      "visitors_today": 12,
      "archived_docs": 345,
      "total_documents": 89,
      "total_reservations": 567,
      "active_accounts": 23
    },
    "visitor_trend": [
      {"date": "2026-01-18", "label": "Mon", "count": 5},
      ...
    ],
    "legal_cases_by_status": {
      "pending": 8,
      "in_progress": 15,
      "completed": 42
    },
    "last_updated": "2026-01-24T02:30:15+08:00"
  }
}
```

**Example**:
```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  "https://administrative.test/api/admin/dashboard/metrics?cache_ttl=120"
```

---

### GET /api/admin/dashboard/analytics

**Description**: Get additional decision-making analytics.

**Authentication**: Required

**Response**:
```json
{
  "success": true,
  "data": {
    "legal_case_aging": {...},
    "top_facilities": [...],
    "document_throughput": {...}
  }
}
```

---

### POST /api/admin/dashboard/cache/clear

**Description**: Clear dashboard metrics cache.

**Authentication**: Required

**Response**:
```json
{
  "success": true,
  "message": "Dashboard cache cleared successfully"
}
```

---

## Performance Optimization

### Caching Strategy

**Default TTL**: 60 seconds

**Cache Key**: `dashboard_metrics`

**Usage**:
```php
// Use cached metrics (60s TTL)
$metrics = $metricsService->getCachedMetrics();

// Use cached metrics with custom TTL
$metrics = $metricsService->getCachedMetrics(120);

// Bypass cache
$metrics = $metricsService->getAllMetrics();

// Clear cache
$metricsService->clearCache();
```

**Recommendation**: Use 60-120 second cache for production dashboards with high traffic.

---

### Database Indexes

All dashboard queries are optimized with targeted indexes:

| Table | Index Name | Columns | Purpose |
|-------|-----------|---------|---------|
| `visitor` | `idx_visitor_time_in` | `time_in` | Visitors today, trend queries |
| `documents` | `idx_documents_status` | `status` | Status-based filtering |
| `documents` | `idx_documents_archived_at` | `archived_at` | Archived documents query |
| `documents` | `idx_documents_status_archived` | `status`, `archived_at` | Total documents query |
| `documents` | `idx_documents_created_at` | `created_at` | Throughput queries |
| `facility_reservations` | `idx_facility_reservations_facility_id` | `facility_id` | Top facilities query |
| `facility_reservations` | `idx_facility_reservations_created_at` | `created_at` | Reservation metrics |
| `legal_cases` | `idx_legal_cases_status` | `status` | Status grouping |
| `legal_cases` | `idx_legal_cases_created_at` | `created_at` | Case aging |
| `legal_cases` | `idx_legal_cases_resolved_at` | `resolved_at` | Completed case aging |
| `department_accounts` | `idx_department_accounts_status` | `status` | Active accounts |

**Migration**: Run `php artisan migrate` to apply indexes.

---

## Extension Guide

### Adding a New KPI Metric

1. **Add method to DashboardMetricsService**:
```php
/**
 * NEW METRIC NAME
 * 
 * Definition: Clear description
 * Table: table_name
 * Field: field_name
 * Exclusions: List any exclusions
 */
public function getNewMetric(): int
{
    return Model::where('condition', 'value')->count();
}
```

2. **Update getKPIs() method**:
```php
public function getKPIs(): array
{
    return [
        // ... existing metrics
        'new_metric' => $this->getNewMetric(),
    ];
}
```

3. **Add unit test**:
```php
/** @test */
public function it_counts_new_metric_correctly()
{
    // Arrange: Create test data
    Model::factory()->count(5)->create(['condition' => 'value']);
    
    // Act
    $count = $this->service->getNewMetric();
    
    // Assert
    $this->assertEquals(5, $count);
}
```

4. **Add database index if needed** (see migration file for examples)

5. **Update this documentation** with metric definition

---

### Adding a New Status Mapping

If legal cases introduce new status values:

1. **Update getLegalCasesByStatus() method**:
```php
$inProgress = ($statusCounts['under_investigation'] ?? 0)
            + ($statusCounts['awaiting_review'] ?? 0)
            + ($statusCounts['needs_more_info'] ?? 0)
            + ($statusCounts['ongoing'] ?? 0)
            + ($statusCounts['new_status_value'] ?? 0); // Add here
```

2. **Update documentation** status mapping table

3. **Add test case** for new status

---

## Testing

### Run Unit Tests

```bash
# Run all dashboard tests
php artisan test --filter DashboardMetricsServiceTest

# Run specific test
php artisan test --filter it_counts_visitors_today_correctly

# Run with coverage
php artisan test --coverage --filter DashboardMetricsServiceTest
```

### Manual Testing Checklist

- [ ] Verify visitors today count matches database query
- [ ] Confirm 7-day trend has exactly 7 entries with zero-fill
- [ ] Check timezone boundaries (test at midnight)
- [ ] Validate legal case status mapping
- [ ] Test cache functionality (verify TTL)
- [ ] Confirm API endpoint authentication
- [ ] Test error handling (database connection failure)

---

## Troubleshooting

### Issue: Metrics return 0 or unexpected values

**Diagnosis**:
1. Check database connection
2. Verify timezone configuration in `config/app.php`
3. Inspect raw database queries:
   ```php
   DB::enableQueryLog();
   $metrics = $metricsService->getAllMetrics();
   dd(DB::getQueryLog());
   ```

**Solution**: Ensure timezone is set to `Asia/Manila` and database has data.

---

### Issue: Slow dashboard load times

**Diagnosis**:
1. Check if indexes are applied: `SHOW INDEX FROM visitor;`
2. Monitor query execution time
3. Verify cache is enabled

**Solution**:
1. Run migration to add indexes
2. Increase cache TTL to 120-300 seconds
3. Consider adding Redis for cache backend

---

### Issue: Legal case counts don't match UI

**Diagnosis**: Status mapping may be incomplete

**Solution**: Review `getLegalCasesByStatus()` method and ensure all status values are mapped.

---

## Security Considerations

### RBAC (Role-Based Access Control)

Currently, the API endpoint requires authentication but does not restrict by role. To add role restrictions:

**Uncomment in AdminDashboardController**:
```php
if (!in_array(auth()->user()->role ?? '', ['admin', 'superadmin', 'legal', 'manager'])) {
    return response()->json([
        'success' => false,
        'message' => 'Unauthorized access to dashboard metrics'
    ], 403);
}
```

### Data Exposure

Metrics return **aggregated counts only** - no sensitive details (names, emails, case details) are exposed.

### Rate Limiting

Consider adding rate limiting to prevent abuse:
```php
Route::middleware(['auth:sanctum', 'throttle:60,1'])->prefix('admin/dashboard')->group(...);
```

---

## Maintenance

### Regular Tasks

1. **Monitor cache hit rate** (if using Redis)
2. **Review query performance** monthly
3. **Update status mappings** when legal workflow changes
4. **Validate metric accuracy** quarterly

### Backup Considerations

Dashboard metrics are derived from source tables. Ensure regular backups of:
- `visitor`
- `documents`
- `legal_cases`
- `facility_reservations`
- `department_accounts`

---

## Change Log

| Date | Version | Changes |
|------|---------|---------|
| 2026-01-24 | 1.0.0 | Initial implementation with 5 KPIs, visitor trend, legal case status |

---

## Support

For questions or issues:
1. Review this documentation
2. Check unit tests for usage examples
3. Inspect service class PHPDoc comments
4. Contact development team

---

**End of Dashboard Metrics Guide**
