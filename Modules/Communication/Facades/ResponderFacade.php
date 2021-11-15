<?php

namespace Modules\Communication\Facades;

use Imanghafoori\SmartFacades\Facade;
use Modules\Communication\Http\Responses\VueResponses;

class ResponderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VueResponses::class;
    }
}