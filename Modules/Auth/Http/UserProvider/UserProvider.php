<?php

namespace Modules\Auth\Http\UserProvider;

use Modules\Auth\Facades\ResponderFacade;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class UserProvider
{
    public function generateNewUser($request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
    }

    public function blockedUser($email)
    {
        $user = User::where('email', $email)->get() ?: new User;

        return $user->status === 1 ? true : false;
    }

    public function checkUserEmailAndPassword($request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return  ResponderFacade::notFoundUser();
        }

        return $token;
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
            ResponderFacade::forgotPasswordSuccessSendEmail();
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
        }
    }
}
