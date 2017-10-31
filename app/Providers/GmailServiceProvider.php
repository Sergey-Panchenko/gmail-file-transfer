<?php

namespace App\Providers;

use App\Contracts\GoogleClientInterface;
use App\Services\GmailService;
use Illuminate\Support\ServiceProvider;

class GmailServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return GmailService
     */
    public function register()
    {
        $this->app->singleton(GmailService::class, function () {
            return new GmailService();
        });
    }
}
