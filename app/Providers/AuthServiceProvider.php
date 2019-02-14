<?php

namespace App\Providers;

use App\Auth\RedaxoGuard;
use App\Foundation\Application;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \Auth::extend('redaxo', function (Application $app, string $name, array $config): Guard {
            return new RedaxoGuard(\Auth::createUserProvider($config['provider']));
        });
    }
}
