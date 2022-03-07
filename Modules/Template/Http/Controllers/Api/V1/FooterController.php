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
        $footer =  Footer::first();
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

        Footer::updateOrCreate(
            ['id' => 1],
            ['link' => $request->section]
        );

        return response()->json([
            'message' => 'اطلاعات هدر صفحه بروز رسانی شد'
        ], Response::HTTP_OK);
    }
}
