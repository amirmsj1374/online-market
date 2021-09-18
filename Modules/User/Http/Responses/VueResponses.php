<?php

namespace Modules\User\Http\Responses;

use Illuminate\Http\Response;
use Modules\User\Entities\User;

class VueResponses
{
    public function index($users)
    {
        return response()->json(
            [
                'data' => $users
            ],
            Response::HTTP_OK
        );
    }
 
    public function createUserSuccess()
    {
        return response()->json([
            'message' => 'کاربر جدید با موفقیت ایجاد شد'
        ], Response::HTTP_CREATED);
    }

    public function updateUserSuccess()
    {
        return response()->json([
            'message' => 'کاربر مورد نظر با موفقیت ویرایش شد'
        ]);
    }

    public function show($user)
    {
        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }


    public function destroyUserSuccess()
    {
        return response()->json([
            'message' => 'کاربر مورد نظر با موفقیت حذف شد'
        ]);
    }
}
