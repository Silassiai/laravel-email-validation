<?php

namespace Silassiai\LaravelEmailValidation;

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