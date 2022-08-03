<?php

namespace Silassiai\LaravelEmailValidation\Facades;

use Illuminate\Support\Facades\Facade;
use Silassiai\LaravelEmailValidation\Validation\EmailValidation;

class EmailValidationFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return EmailValidation::class;
    }

}