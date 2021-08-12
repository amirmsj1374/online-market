<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use AliBayat\LaravelCategorizable\Category;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return response()->json([
            'items' => Category::all()->toArray()
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {

        if (is_null($request->parent)) {

            Category::create(['name' => $request->name]);
        } else {

            Category::create(['name' => $request->name]);
            $parent = Category::findById($request->parent);
            $child = Category::findByName($request->name);
            $parent->appendNode($child);
        }

        return response()->json([
            'items' => Category::all()
        ], Response::HTTP_CREATED);
    }


    /**
     * edit
     *
     * @return void
     */
    public function edit(Request $request)
    {
        $category = Category::findById($request->id);

        if ($category->count() > 0) {
            $category->update([
                'name' => $request->name
            ]);

            return response()->json([
                'items' => Category::all()
            ], Response::HTTP_OK);
        }


        return response()->json([
            'message' => 'اطلاعات وارد شده صحیح نمی باشد'
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $category = Category::findById($id);
        if ($category->count() > 0) {
            $category->delete();

            return response()->json([
                'items' => Category::all()
            ], Response::HTTP_OK);
        }


        return response()->json([
            'message' => 'اطلاعات وارد شده صحیح نمی باشد'
        ], Response::HTTP_NOT_FOUND);
    }
}
