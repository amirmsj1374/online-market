<?php

namespace Modules\Auth\Http\Authenticator;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Facades\ResponderFacade;

class SessionAuth
{
    public function check()
    {
        return Auth::check();
    }

    public function checkUserEmailAndPassword($request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return  ResponderFacade::notFoundUser();
        }

        return $token;
    }
}
