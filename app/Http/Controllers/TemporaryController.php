<?php

namespace App\Http\Controllers;

use AliBayat\LaravelCategorizable\Category;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Product;

class TemporaryController extends Controller
{
    public function save(Request $request)
    {


        $date =
            new DateTime();
        $name =
            'temporary/' . $date->format('Y-m-d') . '/';
        // $path = storage_path('app/public/temporary/' . $file_name);
        $file = Storage::disk("public")->put($name, $request->file);
        $url = Storage::url($file);

        return response()->json([
            'url' => asset($url)
        ]);
    }

    public function test()
    {
        $array = [1, 4, 2, 5];
        $products = collect();
        foreach ($array as $key => $id) {
            $data = Category::find($id)->entries(Product::class)->get();
            if ($data->isNotEmpty()) {
                $products->push($data);
            }
        }

        // dd($products->flatten()->unique('id'));
        foreach ($products->flatten()->unique('id') as $key => $value) {
            dd($value->final_price);
        }

        // $directories = Storage::disk('public')->directories('temporary');
        // foreach ($directories as $key => $directory) {
        //     unset($directory);
        // }
        // dd($directories);

        // return ( \Modules\Product\Entities\Product::find(2)->tags);



    }
}
