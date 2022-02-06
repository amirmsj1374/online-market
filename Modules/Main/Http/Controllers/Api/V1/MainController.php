<?php

namespace Modules\Main\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function saveTemporaryImages(Request $request)
    {
        $urls = [];
        foreach ($request->files as $key => $file) {
            $date = new DateTime();
            $name = 'temporary/' . $date->format('Y-m-d') . '/';
            // $path = storage_path('app/public/temporary/' . $file_name);
            $file = Storage::disk("public")->put($name, $file);
            $urls[$key] = asset(Storage::url($file));
        }

        Log::info([
            'urllllls' => $urls
        ]);

        return response()->json([
            'url' => $urls
        ]);
    }
}
