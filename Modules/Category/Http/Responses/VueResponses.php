<?php

namespace Modules\Category\Http\Responses;

use AliBayat\LaravelCategorizable\Category;
use Illuminate\Http\Response;

class VueResponses
{
    public function index($categories)
    {
        return response()->json([
            'items' => $categories
        ], Response::HTTP_OK);
    }

    public function getAllCategory()
    {
        return response()->json([
            'items' => Category::all()
        ], Response::HTTP_OK);
    }

    public function editFailed()
    {
        return response()->json([
            'message' => 'اطلاعات وارد شده صحیح نمی باشد'
        ], Response::HTTP_NOT_FOUND);
    }


    public function destroyFailed()
    {
        return response()->json([
            'message' => 'اطلاعات وارد شده صحیح نمی باشد'
        ], Response::HTTP_NOT_FOUND);
    }
    public function filterCategories($categories)
    {
        return response()->json([
            'category' => $categories
        ], Response::HTTP_OK);
    }
}
