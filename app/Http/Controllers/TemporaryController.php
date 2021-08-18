<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
}
