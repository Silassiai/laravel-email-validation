<?php

namespace Silassiai\LaravelEmailValidation\Validation;

class EmailValidation
{
    public $test;
    public function __construct($test)
    {
        dd($test);
    }

    public function hasTypo()
    {
        return 'yes';
    }
}