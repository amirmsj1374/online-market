<?php

namespace Modules\Order\Facades;

use Imanghafoori\SmartFacades\Facade;
use Modules\Auth\Http\Responses\VueResponses;

class ResponderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VueResponses::class;
    }
}