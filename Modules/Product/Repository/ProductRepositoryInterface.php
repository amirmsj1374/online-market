<?php

namespace Modules\Product\Repository;

use Illuminate\Http\Request;
use Modules\Product\Entities\Product;

interface ProductRepositoryInterface
{
    public function index();
    public function update($request, $product);
    public function create($request);
    public function updateImages();
    public function updateTags($request, $product);
    public function updateCategory($request, $product);
}
