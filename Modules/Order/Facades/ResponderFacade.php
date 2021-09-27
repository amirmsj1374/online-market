<?php

namespace Modules\Order\Facades;

use Imanghafoori\SmartFacades\Facade;
use Modules\Order\Http\Responses\VueResponses;

class ResponderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VueResponses::class;
    }
}