<?php

namespace App\Console\Commands;

use App\Services\Microservices\ServiceRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MicroserviceHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'microservice:health-check {--service= : Check specific service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check health status of all microservices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting microservice health check...');

        $services = ServiceRegistry::getAllServices();
        
        if ($specificService = $this->option('service')) {
            if (!isset($services[$specificService])) {
                $this->error("Service '{$specificService}' not found");
                return 1;
            }
            $services = [$specificService => $services[$specificService]];
        }

        $healthyCount = 0;
        $totalCount = count($services);

        foreach ($services as $name => $config) {
            $this->line("Checking {$name}...");
            
            $isHealthy = ServiceRegistry::isServiceHealthy($name);
            $status = $isHealthy ? '✅ Healthy' : '❌ Unhealthy';
            $url = $config['url'];
            
            $this->line("  {$name} ({$url}): {$status}");
            
            if ($isHealthy) {
                $healthyCount++;
            } else {
                Log::warning("Microservice health check failed", ['service' => $name, 'url' => $url]);
            }
        }

        $this->info("\nHealth Check Summary:");
        $this->line("  Total Services: {$totalCount}");
        $this->line("  Healthy: {$healthyCount}");
        $this->line("  Unhealthy: " . ($totalCount - $healthyCount));

        if ($healthyCount === $totalCount) {
            $this->info('✅ All services are healthy');
            return 0;
        } else {
            $this->error('❌ Some services are unhealthy');
            return 1;
        }
    }
}
