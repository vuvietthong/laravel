<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        //LOG Query
        // Setup Winston logger
        $logger = new Logger('query');
        $logPath = storage_path('logs/query.log');

        // Create a rotating file handler to log daily
        $handler = new RotatingFileHandler($logPath, 14, Logger::INFO);

        // Customize the log format if needed
        $handler->setFormatter(new \Monolog\Formatter\LineFormatter("[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n", 'Y-m-d H:i:s'));

        // Add the handler to the logger
        $logger->pushHandler($handler);

        // Listen to database queries and log if execution time is greater than 200 milliseconds
        DB::listen(function ($query) use ($logger) {
            $executionTime = $query->time;

            // Check if the query execution time is greater than 200 milliseconds
            if ($executionTime) {
                $logger->info("[$query->time ms] $query->sql");
            }
        });
    }
}
