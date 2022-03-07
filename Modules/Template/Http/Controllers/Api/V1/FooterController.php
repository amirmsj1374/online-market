<?php

namespace Modules\Template\Http\Controllers\Api\V1;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Template\Entities\Footer;

class FooterController extends Controller
{

    public function showFooter()
    {
        $footer =  Footer::get();
        return response()->json([
            'footer' => $footer
        ], Response::HTTP_OK);
    }

    public function addFooter(Request $request)
    {

        $request->validate([
            'section.*.link' => 'nullable|string',
            'section.*.label' => 'nullable|string',
            'section.*.type' => 'nullable|string',
        ]);

        $links = json_encode($request->section, true); // Needs to be decoded

        Footer::updateOrCreate([
            'link' => $links,
        ], ['id' => 1]);

        return response()->json([
            'message' => 'اطلاعات هدر صفحه بروز رسانی شد'
        ], Response::HTTP_OK);
    }
}
