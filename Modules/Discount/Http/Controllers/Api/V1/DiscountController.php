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
use Morilog\Jalali\Jalalian;
use Illuminate\Validation\Rule;

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
                'discount' => $discount
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
            ->paginate(5);

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
        $request->request->set('amount', str_replace('%', '', $request->amount));

        $request->validate([
            'code' => 'nullable|string|unique:discounts,code',
            'amount' => 'required',
            'maxDiscount' => 'nullable',
            'minPrice' => 'nullable',
            'measure' => 'required',
            'description' => 'required|string',
            'limit' => 'boolean',
            'type' => 'required',
            'selected' => 'nullable',
            'beginning' => 'required|string',
            'expiration' => 'required|string',
        ]);



        $request->request->set('expiration', Jalalian::fromFormat('Y-m-d H:i', $request->input('expiration'))->toCarbon());
        $request->request->set('beginning', Jalalian::fromFormat('Y-m-d H:i', $request->input('beginning'))->toCarbon());

        $discount = Discount::create([
            'code' => $request->code,
            'amount' => $request->amount,
            'maxDiscount' => $request->maxDiscount,
            'minPrice' => $request->minPrice,
            'measure' => $request->measure,
            'description' => $request->description,
            'limit' => $request->limit,
            'type' => $request->type,
            // 'selected' => $request->selected,
            'beginning' => $request->beginning,
            'expiration' => $request->expiration,
            // 'status' => true,
        ]);

        if ($request->type === 'basket') {

            if (empty($request->selected) || $request->selected === null) {
                foreach (User::get() as  $user) {
                    $this->saveDiscountCodeForUser($user, $request->code);
                }
            } else {
                foreach ($request->selected as $selected) {
                    $user  = User::find($selected['id']);
                    $profile = $user->profile;

                    $this->saveDiscountCodeForUser($user, $request->code);
                }
            }
        }


        // update selected column by given ID of related table
        $array = array();
        foreach ($request->selected as $key => $selected) {
            array_push($array, $selected['id']);
        }
        $discount->update([
            'selected' => $array
        ]);


        if ($request->type == 'product') {
            foreach ($request->selected as $key => $selected) {
                $product = Product::find($selected['id']);
                $this->saveFinalPriceForProduct($product, $request->measure, $request->amount);
            }
        }

        if ($request->type == 'category') {
            $products = collect();
            foreach ($request->selected as $key => $selected) {
                $data = Category::find($selected['id'])->entries(Product::class)->get();
                if ($data->isNotEmpty()) {
                    $products->push($data);
                }
            }
            $products->flatten()->unique('id');

            foreach ($products as $key => $product) {
                $this->saveFinalPriceForProduct($product, $request->measure, $request->amount);
            }
        }

        return response()->json([
            'message' => 'تخفیف با موفقیت ثبت شد '
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
        $request->request->set('amount', str_replace('%', '', $request->amount));
        $request->validate([
            'code' => [
                'nullable',
                'string',
                Rule::unique('discounts')->ignore($discount->id),
            ],
            'amount' => 'required',
            'measure' => 'required',
            'description' => 'required|string',
            'beginning' => 'required|string',
            'expiration' => 'required|string',
        ]);
        $request->request->set('expiration', Jalalian::fromFormat('Y-m-d H:i', $request->input('expiration'))->toCarbon());
        $request->request->set('beginning', Jalalian::fromFormat('Y-m-d H:i', $request->input('beginning'))->toCarbon());


        $discount->update([
            'code' => $request->code,
            'amount' => $request->amount,
            'measure' => $request->measure,
            'description' => $request->description,
            'beginning' => $request->beginning,
            'expiration' => $request->expiration,
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
        Log::info(['discount del' => $discount]);
        if ($discount->type === 'product') {
        } else if ($discount->type === 'basket') {
        } else if ($discount->type === 'category') {
            $discount->delete();
        }       
        return response()->json([
            'message' => 'اطلاعات تخفیف حذف شد'
        ], Response::HTTP_OK);
    }

    public function saveDiscountCodeForUser($user, $code)
    {
        $profile  = $user->profile;

        if ($profile) {
            $newProfileDiscountCode = $profile->discount_code;

            if (is_null($newProfileDiscountCode)) {
                $newProfileDiscountCode = [];
            }

            array_push($newProfileDiscountCode, $code);
            $profile->discount_code = $newProfileDiscountCode;
            $profile->save();
        } else {
            $user->profile()->create([
                'discount_code' => [$code]
            ]);
        }
    }

    public function saveFinalPriceForProduct($product, $measure, $amount)
    {
        if ($measure === 'percent') {
            Log::info(['selseceferd' => $product]);
            $product->update([
                'final_price' => $product->final_price * (100 - $amount) / 100
            ]);
        } else {
            if ($amount > $product->final_price) {
                $product->update([
                    'final_price' => $product->final_price - $amount
                ]);
            }
        }
    }
}
