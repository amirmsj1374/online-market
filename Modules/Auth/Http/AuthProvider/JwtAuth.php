<?php

namespace Modules\Auth\Http\AuthProvider;

use Modules\Auth\Facades\ResponderFacade;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;

class JwtAuth
{
    public function generateNewUser($request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
    }

    public function check()
    {
        return Auth::check();
    }

    public function authenticationWithEmailAndPassword($request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return  ResponderFacade::notFoundUser();
        }

        return $token;
    }

    public function blockedUser($email)
    {
        $user = User::where('email', $email)->first() ?: new User;

        return $user->status === 0 ? true : false;
    }

    public function logout()
    {
        auth()->logout();
    }

    public function forgotPassword($request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return ResponderFacade::forgotPasswordSuccessSendEmail();
        } else {
            return ResponderFacade::forgotPasswordFailedSendmail();
        }
    }

    public function resetPassword($request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return ResponderFacade::resetPasswordSuccessSendEmail();
        } else {
            return ResponderFacade::resetPasswordFailedSendmail();
        }
    }
}
