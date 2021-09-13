<?php

namespace Modules\Auth\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Modules\Auth\Facades\AuthFacade;
use Modules\Auth\Facades\ResponderFacade;
use Modules\Auth\Facades\UserProviderFacade;
use Modules\Auth\Http\Requests\ForgotRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        UserProviderFacade::generateNewUser($request);
        return  ResponderFacade::createNewUser();
    }

    public function login(LoginRequest $request)
    {
        //check if user blocked
        $this->checkUserIsGuest();
        // validate user is guest
        $status = UserProviderFacade::blockedUser($request->email);
        if ($status) {
            ResponderFacade::blockedUser()->throwResponse();
        }

        $token = UserProviderFacade::checkUserEmailAndPassword($request);
        return  ResponderFacade::respondWithToken($token);
    }

    public function user()
    {
        return ResponderFacade::user(auth()->user());
    }

    public function logout()
    {
        UserProviderFacade::logout();
        return ResponderFacade::logout();
    }

    public function refresh()
    {
        return  ResponderFacade::respondWithToken(auth()->refresh());
    }

    /**
     * send email for reset password
     *
     * @param  mixed $request
     * @return void
     */
    public function forgotPassword(ForgotRequest $request)
    {
        UserProviderFacade::forgotPassword($request);
        return ResponderFacade::forgotPasswordFailedSendmail();
    }

    /**
     * enter new password
     *
     * @param  mixed $request
     * @return void
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        UserProviderFacade::resetPassword($request);
        return ResponderFacade::resetPasswordFailedSendmail();
    }

    private function checkUserIsGuest()
    {
        if (AuthFacade::check()) {
            ResponderFacade::youShouldBeGuest()->throwResponse();
        }
    }
}
