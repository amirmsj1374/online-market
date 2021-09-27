<?php

namespace Modules\Product\Interfaces;

use Modules\Product\Entities\Product;

interface ProductRepositoryInterface
{
    public function index();
    public function show(Product $product);
    public function create($request);
    public function update($request, $product);
    public function syncTags($request, $product);
    public function syncCategories($request, $product);
    public function syncDownloads($links, $product);
    public function attachAttributesToProduct($attributes, $product);
    public function filterProducts($request);
}
