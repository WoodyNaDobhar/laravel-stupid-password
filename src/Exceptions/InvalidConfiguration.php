<?php

namespace WoodyNaDobhar\LaravelStupidPassword\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function noEnvironmentals()
    {
        return new static('A configuration error has occured validating the password.  Please notify the developer.');
    }
}