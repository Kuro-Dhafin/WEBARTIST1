<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use App\Models\Service;
use App\Policies\OrderPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
    Service::class => ServicePolicy::class,
    Order::class => OrderPolicy::class,
    User::class => UserPolicy::class,
    
];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user) {
            if ($user->role === 'admin') {
                return true;
            }
        });
    }
}
