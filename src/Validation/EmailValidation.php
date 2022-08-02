<?php

namespace Silassiai\LaravelEmailValidation\Validation;

class EmailValidation
{
    public function __construct($test)
    {
        dd($this->test);
    }

    public function hasTypo()
    {
        return 'yes';
    }
}