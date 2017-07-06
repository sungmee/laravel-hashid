<?php

namespace Sungmee\Hashid\Facades;

use Illuminate\Support\Facades\Facade;

class Hashid extends Facade {
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Hashid';
    }
}