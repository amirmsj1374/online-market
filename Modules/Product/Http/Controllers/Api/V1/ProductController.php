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
        $products = resolve(ProductRepository::class)->index();
        return response()->json([
            'products' => $products,
            'message' => 'every thing is good'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        Log::info([
            'create product' => $request->all()
        ]);

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'body' => 'nullable|string',
        ]);

        $product = ($this->repository)->create($request);

        return response()->json([
            // 'product' => $product,
            'message' => 'محصول با موفقیت ایجاد شد'
        ], Response::HTTP_CREATED);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('product::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
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
        ], 200);
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
        ], 200);
    }
}
