<?php

namespace Silassiai\LaravelEmailValidation;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Jenssegers\Agent\Agent;
use Silassiai\LaravelEmailValidation\Commands\SeedMailProviderDomains;
use Silassiai\LaravelEmailValidation\Validation\EmailValidation;

class EmailValidationServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        if (app()->runningInConsole()) {
            $this
                ->registerMigrations()
                ->registerCommands();
        }

        $this->publishes([
            __DIR__.'/../publishes/Models/' => app_path('/Models')
        ], 'silassiai-models');
    }

    public function register()
    {
        $this->app->singleton(
            EmailValidation::class,
            fn($app) => new EmailValidation('')
        );
    }

    public function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        return $this;
    }
    
    public function registerCommands()
    {
        $this->commands([
            SeedMailProviderDomains::class,
        ]);
        return $this;
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [EmailValidation::class, EmailValidation::class];
    }
}