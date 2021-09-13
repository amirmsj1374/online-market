<?php

namespace Modules\Auth\Http\Responses;

use Illuminate\Http\Response;

class VueResponses
{
    public function createNewUser()
    {
        return response()->json([
            'message' => 'اطلاعات کاربر جدید ثبت شد'
        ], Response::HTTP_OK);
    }

    public function blockedUser()
    {
        return response()->json([
            'error' => 'کاربری شما در سیستم محدود شده است'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function youShouldBeGuest()
    {
        return response()->json([
            'error' => 'شما در سیستم لاگین هستید'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ],  Response::HTTP_OK);
    }


    public function notFoundUser()
    {
        return response()->json([
            'error' => 'کاربری با مشخصات زیر یافت نشد یا دسترسی کاربر محدود شده است'
        ],  Response::HTTP_UNAUTHORIZED);
    }


    public function logout()
    {
        return response()->json([
            'message' => 'از سیستم خارج شدید'
        ],  Response::HTTP_OK);
    }

    public function user()
    {
        return response()->json(auth()->user());
    }


    public function forgotPasswordSuccessSendEmail()
    {
        return response()->json([
            'message' => 'لطفا ایمیل خود را چک کنید'
        ], Response::HTTP_OK);
    }

    public function forgotPasswordFailedSendmail()
    {
        return response()->json([
            'message' => 'اطلاعات یافت نشد'
        ], Response::HTTP_NOT_FOUND);
    }

    public function resetPasswordSuccessSendEmail()
    {
        return response()->json([
            'message' => 'اطلاعات با موفقیت تغییر کرد'
        ], Response::HTTP_OK);
    }
    
    public function resetPasswordFailedSendmail()
    {
        return response()->json([
            'message' => 'اطلاعات وارد شده صحیح نمی باشد '
        ], Response::HTTP_BAD_REQUEST);
    }
}
