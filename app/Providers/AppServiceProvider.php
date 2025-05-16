<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Create the storage symbolic link if it doesn't exist
        if (!file_exists(public_path('storage'))) {
            try {
                \Illuminate\Support\Facades\Artisan::call('storage:link');
            } catch (\Exception $e) {
                \Log::error('Storage link creation failed: ' . $e->getMessage());
            }
        }

        // Ensure storage directories exist
        $this->ensureDirectoryExists('app/public/contracts');
        $this->ensureDirectoryExists('app/public/contracts/signatures');
    }

    /**
     * Helper method to ensure a directory exists in storage
     */
    private function ensureDirectoryExists(string $path): void
    {
        $fullPath = storage_path($path);
        if (!file_exists($fullPath)) {
            try {
                mkdir($fullPath, 0755, true);
            } catch (\Exception $e) {
                \Log::error("Failed to create directory {$path}: " . $e->getMessage());
            }
        }
    }
}
