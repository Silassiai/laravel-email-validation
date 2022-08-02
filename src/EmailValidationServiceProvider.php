<?php

namespace Silassiai\LaravelEmailValidation;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class EmailValidationServiceProvider extends BaseServiceProvider
{
    public function register()
    {
//        if (app()->runningInConsole()) {
            $this->registerMigrations();
//        }

        $this->app->singleton(
            EmailValidation::class,
            function($app){
                return new EmailValidation('asd');
            }
        );
    }

    public function registerMigrations()
    {
        return $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}