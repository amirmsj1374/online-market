<?php

namespace Modules\Communication\Http\Responses;

use Illuminate\Http\Response;

class VueResponses
{
    public function comment($comments, $product)
    {
        return response()->json([
            'comments' => $comments,
            'numberOfComments' => count($comments),
            'user_id' => auth()->id()
        ], Response::HTTP_OK);
    }

    public function product($products)
    {
        return response()->json([
            'products' => $products
        ], Response::HTTP_OK);
    }

    public function store()
    {
        return response()->json([
            'messsage' => 'پاسخ به نظر اضاف گردید',
        ], Response::HTTP_OK);
    }

    public function changeCommentMode()
    {
        return response()->json([
            'message' => 'وضعیت نظر ثبت شده تغییر داده شد',
        ]);
    }

    public function delete()
    {
        return response()->json(['message' => 'نظر کاربر حذف شد',
        ]);
    }
}
