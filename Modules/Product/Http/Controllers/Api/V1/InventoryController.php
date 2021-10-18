<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Product;
use Modules\Product\QueryFilter\Title;

class InventoryController extends Controller
{

    public function filter(Request $request)
    {
        $products = app(Pipeline::class)

            ->send(Product::query())

            ->through([
                Title::class,
            ])

            ->thenReturn()
            // ->paginate(7);
            ->get();

        $collection = collect();
        foreach ($products as $key => $product) {
            foreach ($product->inventories as $key => $inventory) {
                $inventory['title'] = $product->title;
                $collection->push($inventory);
            }
        }

        return response()->json([
            'products' => $collection->paginate(5)
        ]);
    }
}
