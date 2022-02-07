<?php

namespace Modules\Main\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function saveTemporaryImages(Request $request)
    {
        $urls = [];
        foreach ($request->file() as $key => $file) {
            $date = new DateTime();
            $path = 'temporary/' . $date->format('Y-m-d') . '/';
            File::makeDirectory(storage_path($path), $mode = 0777, true, true);
            $file = Storage::disk("public")->put($path, $file);
            $urls[$key] = asset(Storage::url($file));
        }

        return response()->json([
            'urls' => $urls
        ]);
    }
}
