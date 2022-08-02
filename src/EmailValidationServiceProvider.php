<?php

namespace Silassiai\LaravelEmailValidation;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Silassiai\LaravelEmailValidation\Validation\EmailValidation;

class EmailValidationServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        var_dump(24);exit;
    }
    public function register()
    {
        var_dump(24);exit;
        $this->app->singleton(
            EmailValidation::class,
            function($app){
                return new EmailValidation('asd');
            }
        );
    }
}