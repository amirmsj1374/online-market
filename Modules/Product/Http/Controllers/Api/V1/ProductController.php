<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Product;
use Modules\Product\Repository\ProductRepository;
use Modules\Product\Repository\ProductRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $products = ($this->repository)->index();

        return response()->json([
            'products' => $products,
        ], Response::HTTP_OK);
    }

    /**
     * show
     *
     * @param  mixed $product
     * @return void
     */
    public function show(Product $product)
    {
        $product = ($this->repository)->show($product);

        // Log::info([
        //     'product' => $product
        // ]);

        return response()->json([
            'product' => $product,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {

        $request->request->set('price', str_replace(',','',$request->price));

        if ($request->hasFile('images') && count($request->images) > 0) {

            $validator = Validator::make(
                $request->all(),
                [
                    'images.*' => 'required|mimes:jpg,jpeg,png,bmp|max:2000'
                ],
                [
                    'images.*.required' => 'لطفا فقط فایل های تصیری را وارد کنید',
                    'images.*.mimes' => 'تصاویر باید از نوع[jpeg,jpg,bnp] باشد',
                    'images.*.max' => 'حداکثر حجم فیل باید2MB  باشد',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->getMessageBag()->toArray()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $request->validate([

            'title' => 'required|string',
            'description' => 'required|string',
            'body' => 'nullable|string',
            'tags' => 'nullable',

            'quantity' => 'nullable',
            'price' => 'nullable',
            'sku' => 'nullable|string',

            'length' => 'nullable',
            'width' => 'nullable',
            'height' => 'nullable',
            'weight' => 'nullable',

            'tax_status' => 'nullable|boolean',
            'virtual' => 'nullable|boolean',
            'downloadable' => 'nullable|boolean',
            'publish' => 'nullable|boolean',
            'min_quantity' => 'nullable',
            'final_price' => 'nullable',
        ]);

        $this->repository->create($request);

        return response()->json([
            'message' => 'محصول با موفقیت ایجاد شد'
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Product $product)
    {

        $request->request->set('price', str_replace(',','',$request->price));

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'body' => 'nullable|string',
            'sku' => 'nullable|string',
            'tax_status' => 'nullable|boolean',
            'virtual' => 'nullable|boolean',
            'downloadable' => 'nullable|boolean',
            'publish' => 'nullable|boolean',
            'quantity' => 'nullable',
            'min_quantity' => 'nullable',
            'price' => 'nullable',
            'final_price' => 'nullable',
        ]);


        $product = ($this->repository)->update($request, $product);

        return response()->json([
            'product' => $product,
            'message' => 'محصول با موفقیت ویرایش شد'
        ], Response::HTTP_OK);
    }

    /**
     * changeStatus
     *
     * @param  mixed $product
     * @return void
     */
    public function changeStatus(Product $product)
    {
        $product->update([
            'publish' => $product->publish === 0 ? 1 : 0
        ]);

        return response()->json([
            'product' => Product::all(),
            'message' => 'وضعیت محصول تغییر کرد'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Product $product)
    {

        $product->delete();
        return response()->json([
            'message' => 'محصول با موفقیت حذف شد'
        ], Response::HTTP_OK);
    }

    public function deleteMedia(Request $request, Product $product)
    {
        // find image from prduct and chack with remove image and delelte
        foreach ($product->getMedia('product-gallery') as $key => $image) {

            if (in_array($image->getFullUrl(), $request->images)) {
                $image->delete();
            }
        }
    }
}
