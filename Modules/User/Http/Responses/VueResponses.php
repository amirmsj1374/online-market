<?php

namespace Modules\User\Http\Responses;

use Illuminate\Http\Response;
use Modules\User\Entities\User;

class VueResponses
{
    public function index()
    {
        return response()->json(['users' => User::with('profile')->paginate(2)
        ], Response::HTTP_OK);
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
    public function destroyUserSuccess()
    {
        return response()->json([
            'message' => 'کاربر مورد نظر با موفقیت حذف شد'
        ]);
    }
}
