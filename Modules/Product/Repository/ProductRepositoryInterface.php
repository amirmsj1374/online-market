<?php

namespace Modules\Product\Repository;

use Illuminate\Http\Request;
use Modules\Product\Entities\Product;

interface ProductRepositoryInterface
{
    public function index();
    public function show(Product $product);
    public function update($request, $product);
    public function create($request);
    public function syncTags($request, $product);
    public function syncCategories($request, $product);
    public function syncDownloads($links, $product);
    public function attachAttributesToProduct($attributes, $product);
}
