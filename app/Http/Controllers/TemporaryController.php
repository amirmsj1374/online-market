<?php

namespace App\Http\Controllers;

use AliBayat\LaravelCategorizable\Category;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class TemporaryController extends Controller
{
    public function save(Request $request)
    {
        Log::info(['re' => $request->all()]);
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:20000'
        ]);


        $date = new DateTime();
        $name ='temporary/' . $date->format('Y-m-d') . '/';
        $file = Storage::disk("public")->put($name, $request->file);
        $url = Storage::url($file);

        return response()->json([
            'url' => asset($url)
        ]);
    }

    public function test()
    {

        // $directories = Storage::disk('public')->directories('temporary');
        // foreach ($directories as $key => $directory) {
        //     unset($directory);
        // }
        // dd($directories);

        // return ( \Modules\Product\Entities\Product::find(2)->tags);

    }

}
