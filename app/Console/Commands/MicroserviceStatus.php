<?php

namespace App\Console\Commands;

use App\Services\Microservices\ServiceRegistry;
use App\Services\Microservices\ServiceGateway;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class MicroserviceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'microservice:status {--detailed : Show detailed metrics}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show detailed status of all microservices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Microservice Status Report');
        $this->info('========================');

        $services = ServiceRegistry::getAllServices();
        $gateway = ServiceGateway::getInstance();
        $healthStatus = $gateway->getHealthStatus();

        $this->table(
            ['Service', 'URL', 'Health', 'Circuit Breaker', 'Failures', 'Successes'],
            $this->formatServiceTable($services, $healthStatus)
        );

        if ($this->option('detailed')) {
            $this->showDetailedMetrics();
        }

        $this->showSummary($services, $healthStatus);
    }

    /**
     * Format service data for table display
     */
    private function formatServiceTable(array $services, array $healthStatus): array
    {
        $tableData = [];

        foreach ($services as $name => $config) {
            $status = $healthStatus[$name] ?? [];
            
            $tableData[] = [
                $name,
                $config['url'],
                $status['healthy'] ? '✅ Healthy' : '❌ Unhealthy',
                $status['circuit_breaker_open'] ? '🔴 Open' : '🟢 Closed',
                $status['recent_failures'] ?? 0,
                $status['recent_successes'] ?? 0,
            ];
        }

        return $tableData;
    }

    /**
     * Show detailed metrics
     */
    private function showDetailedMetrics(): void
    {
        $this->info("\nDetailed Metrics:");
        $this->info('----------------');

        $metrics = ServiceRegistry::getServiceMetrics();

        foreach ($metrics as $name => $metric) {
            $this->line("\n{$name}:");
            $this->line("  URL: {$metric['url']}");
            $this->line("  Health: " . ($metric['healthy'] ? 'Healthy' : 'Unhealthy'));
            $this->line("  Circuit Breaker: " . ($metric['circuit_breaker_open'] ? 'Open' : 'Closed'));
            $this->line("  Last Check: " . ($metric['last_check'] ?? 'Never'));
            
            // Show cache statistics
            $cacheKey = "service_health_{$name}";
            $cached = Cache::has($cacheKey);
            $this->line("  Cached: " . ($cached ? 'Yes' : 'No'));
        }
    }

    /**
     * Show summary statistics
     */
    private function showSummary(array $services, array $healthStatus): void
    {
        $total = count($services);
        $healthy = 0;
        $unhealthy = 0;
        $circuitBreakerOpen = 0;

        foreach ($healthStatus as $status) {
            if ($status['healthy']) {
                $healthy++;
            } else {
                $unhealthy++;
            }
            
            if ($status['circuit_breaker_open']) {
                $circuitBreakerOpen++;
            }
        }

        $this->info("\nSummary:");
        $this->line("  Total Services: {$total}");
        $this->line("  Healthy Services: {$healthy} (" . round(($healthy / $total) * 100, 1) . "%)");
        $this->line("  Unhealthy Services: {$unhealthy} (" . round(($unhealthy / $total) * 100, 1) . "%)");
        $this->line("  Circuit Breakers Open: {$circuitBreakerOpen}");

        if ($unhealthy > 0) {
            $this->warn("\n⚠️  Some services are unhealthy. Check logs for details.");
        }

        if ($circuitBreakerOpen > 0) {
            $this->warn("\n🔴 {$circuitBreakerOpen} circuit breaker(s) are open. Fallback services are being used.");
        }
    }
}
