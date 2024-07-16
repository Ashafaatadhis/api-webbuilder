<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\StorePolicy;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Store Model
        |--------------------------------------------------------------------------
        |
        | A Gate for authorization Store Model
        |
        */
        Gate::define('create-store', [StorePolicy::class, 'create']);
        Gate::define('update-store', [StorePolicy::class, 'update']);
        Gate::define('delete-store', [StorePolicy::class, 'delete']);
    }
}
