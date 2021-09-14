<?php

namespace Modules\User\Facades;

use Imanghafoori\SmartFacades\Facade;
use Modules\User\Http\Responses\VueResponses;

class ResponderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VueResponses::class;
    }
}