<?php

namespace Modules\Category\Facades;

use Imanghafoori\SmartFacades\Facade;
use Modules\Category\Http\Responses\VueResponses;

class ResponderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VueResponses::class;
    }
}