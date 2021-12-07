<?php

namespace Bolivir\VAT\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bolivir\VAT\VAT
 */
class VAT extends Facade
{
    protected static function getFacadeAccessor()
    {
        return '\Bolivir\VAT\VAT';
    }
}
