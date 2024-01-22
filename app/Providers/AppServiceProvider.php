<?php

namespace App\Providers;

use App\Http\Controllers\Finder\ImportWbController;
use App\Services\Contracts\ImportServiceInterface;
use App\Services\ImportWbService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(ImportWbController::class)
            ->needs(ImportServiceInterface::class)
            ->give(ImportWbService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
