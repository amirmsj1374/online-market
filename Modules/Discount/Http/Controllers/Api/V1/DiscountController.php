<?php

namespace Modules\Discount\Http\Controllers\Api\V1;

use AliBayat\LaravelCategorizable\Category;
use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Modules\Discount\Entities\Discount;
use Modules\Product\QueryFilter\Title;
use Modules\User\QueryFilter\Name;
use Morilog\Jalali\Jalalian;
use Illuminate\Validation\Rule;
use Modules\Discount\Facades\ResponderFacade;

class DiscountController extends Controller
{

    public function index()
    {
        $discount = Discount::orderBy('id', 'desc')->paginate(5);
        return ResponderFacade::index($discount);
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

        return ResponderFacade::filterProduct($products);
    }

    public function categories(Request $request)
    {


        $categories = app(Pipeline::class)

            ->send(Category::query())

            ->through([])

            ->thenReturn()
            ->paginate(5);

        return ResponderFacade::filtercategories($categories);
    }

    public function users(Request $request)
    {

        $users = app(Pipeline::class)

            ->send(User::query())

            ->through([
                Name::class,
            ])

            ->thenReturn()
            ->paginate(2);

        return ResponderFacade::filterUser($users);
    }

    public function create(Request $request)
    {
        $this->createValidate($request);

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
            'select_all' => $request->selectAll,
            'beginning' => $request->beginning,
            'expiration' => $request->expiration,
            // 'status' => true,
        ]);

        // update selected column by given ID of related table
        $array = array();
        foreach ($request->selected as $key => $selected) {
            array_push($array, $selected['id']);
        }
        $discount->update([
            'selected' => $array
        ]);

        return ResponderFacade::discountSuccessCreate();
    }

    private function createValidate($request)
    {
       
        $request->request->set('amount', str_replace(',', '', $request->amount));
        $request->request->set('amount', str_replace('%', '', $request->amount));
        $request->request->set('maxDiscount', str_replace(',', '', $request->maxDiscount));
        $request->request->set('minPrice', str_replace(',', '', $request->minPrice));
        $request->request->set('expiration', Jalalian::fromFormat('Y-m-d H:i', $request->input('expiration'))->toCarbon());
        $request->request->set('beginning', Jalalian::fromFormat('Y-m-d H:i', $request->input('beginning'))->toCarbon());


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
            'beginning' => 'required',
            'expiration' => 'required',
        ]);
    }

    public function show(Discount $discount)
    {
        return ResponderFacade::show($discount);
    }

    public function update(Request $request, Discount $discount)
    {

        if ($discount->status === 1) {
            return ResponderFacade::discountUpdateCondition();
        }

        $this->updateValidation($request, $discount);

        $discount->update([
            'code' => $request->code,
            'amount' => $request->amount,
            'measure' => $request->measure,
            'description' => $request->description,
            'beginning' => $request->beginning,
            'expiration' => $request->expiration,
        ]);

        return ResponderFacade::updateSuccess();
    }

    private function updateValidation($request, $discount)
    {
        $request->request->set('amount', str_replace(',', '', $request->amount));
        $request->request->set('amount', str_replace('%', '', $request->amount));
        $request->request->set('expiration', Jalalian::fromFormat('Y-m-d H:i', $request->input('expiration'))->toCarbon());
        $request->request->set('beginning', Jalalian::fromFormat('Y-m-d H:i', $request->input('beginning'))->toCarbon());

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
    }

    public function destroy(Discount $discount)
    {
        if ($discount->type === 'product') {

            if ($discount->select_all === 1) {
                foreach (Product::get() as $product) {
                    $this->changeFinalPriceFromProduct($product);
                }
            } else {
                foreach (json_decode($discount->selected) as $id) {
                    $product = Product::find($id);
                    $this->changeFinalPriceFromProduct($product);
                }
            }
        } else if ($discount->type === 'basket') {

            if ($discount->select_all === 1) {
                foreach (User::get() as  $user) {
                    $this->removeDiscountCodeForUser($user, $discount->code);
                }
            } else {
                foreach (json_decode($discount->selected) as $id) {
                    $user  = User::find($id);
                    $this->removeDiscountCodeForUser($user, $discount->code);
                }
            }
        } else if ($discount->type === 'category') {

            $products = collect();

            if ($discount->select_all === 1) {
                foreach (Category::get() as $category) {
                    $data = $category->entries(Product::class)->get();
                    if ($data->isNotEmpty()) {
                        $products->push($data);
                    }
                }
            } else {
                foreach (json_decode($discount->selected) as $id) {
                    $data = Category::find($id)->entries(Product::class)->get();
                    if ($data->isNotEmpty()) {
                        $products->push($data);
                    }
                }
            }

            foreach ($products->flatten()->unique('id') as $product) {
                $this->changeFinalPriceFromProduct($product);
            }

            $discount->delete();
        }

        return ResponderFacade::destroyDiscount();
    }

    public function removeDiscountCodeForUser($user, $code)
    {
        $profile  = $user->profile;

        if ($profile) {
            $ProfileDiscountCode = $profile->discount_code;

            if (!is_null($ProfileDiscountCode) || !empty($ProfileDiscountCode)) {


                $profile->update([
                    'discount_code' => array_diff($ProfileDiscountCode, [$code])
                ]);
            }
        }
    }

    public function changeFinalPriceFromProduct($product)
    {
        $product->update([
            'final_price' => $product->tax_status === 0 ? $product->price : $product->price * 1.09
        ]);
    }
}
