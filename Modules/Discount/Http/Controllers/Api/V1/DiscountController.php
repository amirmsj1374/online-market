<?php

namespace Modules\Discount\Http\Controllers\Api\V1;

use AliBayat\LaravelCategorizable\Category;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Modules\Product\Entities\Product;
use Illuminate\Pipeline\Pipeline;
use Modules\Product\QueryFilter\Title;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // return view('discount::index');
    }


    public function products(Request $request)
    {


        $products = app(Pipeline::class)

            ->send(Product::query())

            ->through([
                Title::class,
            ])

            ->thenReturn()
            ->paginate(1);

        return response()->json(
            [
                'data' => $products
            ],
            Response::HTTP_OK
        );
    }
    public function categories(Request $request)
    {


        $categories = app(Pipeline::class)

            ->send(Category::query())

            ->through([])

            ->thenReturn()
            ->get();

        return response()->json(
            [
                'data' => $categories
            ],
            Response::HTTP_OK
        );
    }
    public function users(Request $request)
    {


        $users = app(Pipeline::class)

            ->send(User::query())

            ->through([
                Name::class,
            ])

            ->thenReturn()
            ->paginate(1);

        return response()->json(
            [
                'data' => $users
            ],
            Response::HTTP_OK
        );
    }



    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // return view('discount::create');
    }



    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('discount::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('discount::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
