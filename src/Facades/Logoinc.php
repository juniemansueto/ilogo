<?php

namespace ILOGO\Logoinc\Facades;

use Illuminate\Support\Facades\Facade;

class Logoinc extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'logoinc';
    }
}
