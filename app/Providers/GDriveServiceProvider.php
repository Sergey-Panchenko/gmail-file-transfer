<?php

namespace App\Providers;

use App\Contracts\GoogleClientInterface;
use App\Services\GDriveService;
use Illuminate\Support\ServiceProvider;

class GDriveServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return GDriveService
     */
    public function register()
    {
        $this->app->singleton(GDriveService::class, function () {
            return new GDriveService();
        });
    }
}
