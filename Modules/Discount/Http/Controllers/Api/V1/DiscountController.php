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


    public function Required(Request $request)
    {

        if ($request->input('type') === 'basket') {

            $users = User::select('name', 'email', 'mobile', 'id')->where('type', 'user')->orderBy('id', 'desc')->paginate(5);

            return response()->json([
                'data' => $users
            ], Response::HTTP_OK);
        } else if ($request->input('type') === 'product') {

            $products = Product::select('title', 'sku', 'id')->where('publish', '1')->orderBy('id', 'desc')->paginate(5);

            return response()->json([
                'data' => $products
            ], Response::HTTP_OK);
        } else {

            $categores = Category::select('id', 'name')->get();

            return response()->json([
                'data' => $categores
            ], Response::HTTP_OK);
        }
    }

    public function Search(Request $request)
    {
        Log::info(['request' => $request->all()]);

        if ($request->input('type') === 'basket') {
            
        } else if ($request->input('type') === 'product') {

        }
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
