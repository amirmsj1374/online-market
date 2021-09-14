<?php

namespace Modules\User\Http\Responses;

use Illuminate\Http\Response;
use Modules\User\Entities\User;

class VueResponses
{
    public function index()
    {
        return response()->json([
            'users' => User::paginate(2)
        ], Response::HTTP_OK);
    }
}
