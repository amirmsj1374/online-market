<?php

namespace Modules\Discount\Http\Controllers\Api\V1;

use AliBayat\LaravelCategorizable\Category;
use Modules\User\Entities\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Modules\Product\Entities\Product;
use Illuminate\Pipeline\Pipeline;
use Modules\Discount\Entities\Discount;
use Modules\Product\QueryFilter\Title;
use Modules\User\QueryFilter\Name;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $discount = Discount::orderBy('id', 'desc')->paginate(5);

        return response()->json(
            [
                'data' => $discount
            ],
            Response::HTTP_OK
        );
    }


    public function products(Request $request)
    {


        $products = app(Pipeline::class)

            ->send(Product::query())

            ->through([
                Title::class,
            ])

            ->thenReturn()
            ->paginate(5);

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
            ->paginate(1);

        Log::info([
            'cateigory backend' => $categories
        ]);
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
            ->paginate(5);

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
    public function create(Request $request)
    {

        $request->request->set('amount', str_replace(',', '', $request->amount));

        $request->validate([

            'code' => 'nullable|string',
            'amount' => 'required',
            'maxDiscount' => 'nullable',
            'minPrice' => 'nullable',
            'measure' => 'required',
            'description' => 'required|text',
            'limit' => 'boolean',
            'type' => 'required',
            'data' => 'nullable',
            'beginning' => 'date',
            'expriration' => 'date',

        ]);

        Discount::create([
            'code' => $request->code,
            'amount' => $request->amount,
            'maxDiscount' => $request->maxDiscount,
            'minPrice' => $request->minPrice,
            'measure' => $request->measure,
            'description' => $request->description,
            'limit' => $request->limit,
            'type' => $request->type,
            'data' => $request->data,
            'beginning' => $request->beginning,
            'expriration' => $request->expriration,
        ]);

        return response()->json([
            'message' => 'تخفیف ثبت شد '
        ], Response::HTTP_OK);
    }



    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Discount $discount)
    {
        return response()->json([
            'discount' => $discount
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Discount $discount)
    {
        $request->request->set('amount', str_replace(',', '', $request->amount));

        $request->validate([

            'code' => 'nullable|string',
            'amount' => 'required',
            'maxDiscount' => 'nullable',
            'minPrice' => 'nullable',
            'measure' => 'required',
            'description' => 'required|text',
            'limit' => 'boolean',
            'type' => 'required',
            'data' => 'nullable',
            'beginning' => 'date',
            'expriration' => 'date',

        ]);

        $discount->update([
            'code' => $request->code,
            'amount' => $request->amount,
            'maxDiscount' => $request->maxDiscount,
            'minPrice' => $request->minPrice,
            'measure' => $request->measure,
            'description' => $request->description,
            'limit' => $request->limit,
            'type' => $request->type,
            'data' => $request->data,
            'beginning' => $request->beginning,
            'expriration' => $request->expriration,
        ]);

        return response()->json([
            'message' => 'تخفیف ویرایش شد '
        ], Response::HTTP_OK);
    }



    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Discount $discount)
    {

        $discount->delete();
        return response()->json([
            'message' => 'اطلاعات تخفیف حذف شد'
        ], Response::HTTP_OK);
    }
}
