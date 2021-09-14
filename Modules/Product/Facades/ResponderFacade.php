<?php

namespace Modules\Product\Facades;

use Imanghafoori\SmartFacades\Facade;
use Modules\Product\Http\Responses\VueResponses;

class ResponderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VueResponses::class;
    }
}