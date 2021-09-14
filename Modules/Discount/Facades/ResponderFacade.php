<?php

namespace Modules\Discount\Facades;

use Imanghafoori\SmartFacades\Facade;
use Modules\Discount\Http\Responses\VueResponses;

class ResponderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VueResponses::class;
    }
}