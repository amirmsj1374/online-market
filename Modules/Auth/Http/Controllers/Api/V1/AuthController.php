<?php

namespace Modules\Auth\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Facades\ResponderFacade;
use Modules\Auth\Facades\AuthProviderFacade;
use Modules\Auth\Http\Requests\ForgotRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        AuthProviderFacade::generateNewUser($request);
        return  ResponderFacade::createNewUser();
    }

    public function login(LoginRequest $request)
    {
        // validate user is guest
        $this->checkUserIsGuest();

        //check if user is blocked
        $status = AuthProviderFacade::blockedUser($request->email);
        if ($status) {
            ResponderFacade::blockedUser()->throwResponse();
        }

        $token = AuthProviderFacade::authenticationWithEmailAndPassword($request);
        return  ResponderFacade::respondWithToken($token);
    }

    public function user()
    {
        return ResponderFacade::user(auth()->user());
    }

    public function logout()
    {

        AuthProviderFacade::logout();
        return ResponderFacade::logout();
    }

    public function refresh()
    {
        return  ResponderFacade::respondWithToken(auth()->refresh());
    }

    /**
     *
     * send email for reset password
     *
     */
    public function forgotPassword(ForgotRequest $request)
    {
        AuthProviderFacade::forgotPassword($request)->throwResponse();
    }

    /**
     *
     * enter new password
     *
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        AuthProviderFacade::resetPassword($request)->throwResponse();
    }

    /**
     *
     * this method prevent user when login can not try login again
     *
     */
    private function checkUserIsGuest()
    {
        if (AuthProviderFacade::check()) {
            ResponderFacade::youShouldBeGuest()->throwResponse();
        }
    }
}