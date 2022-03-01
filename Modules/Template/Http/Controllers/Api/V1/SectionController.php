<?php

namespace Modules\Template\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Template\Entities\Element;
use Modules\Template\Entities\Page;
use Modules\Template\Facades\ContentRepositoryFacade;
use Modules\Template\Facades\LayoutRepositoryFacade;
use Modules\Template\Facades\PageRepositoryFacade;
use Modules\Template\Facades\SectionRepositoryFacade;

class SectionController extends Controller
{

    public function addSection(Element $element, Request $request)
    {

        // vlidation for slider or banner type
        if (str_contains($element->type, 'slider') || str_contains($element->type, 'banner')) {
            $request->validate([
                'section.*.image' => 'required',
            ]);
        }

        $request->validate([
            'section.*.body' => 'nullable|string',
            'section.*.link' => 'nullable|string',
            'section.*.buttonLabel' => 'nullable|string',
            'section.*.type' => 'nullable|string'
        ]);


        $title = $request->section['title'] ?? null;

        $section = SectionRepositoryFacade::create($element->id, $title);

        // // add section to  layout
        $page = PageRepositoryFacade::find($request->pageId);
        $order = $page->layouts->count()+ 1;

        LayoutRepositoryFacade::create($page, $section->id, $order);

        if (str_contains($element->type, 'slider') || str_contains($element->type, 'banner')) {
            ContentRepositoryFacade::createMultipleContents($section, $request->section);
        } else {
            ContentRepositoryFacade::createContent($section, $request->section);
        }



        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

    // related to banner-advance
    public function addMultipleSections(Element $element, Request $request)
    {

        // add section to  layout

        $page = PageRepositoryFacade::find($request->pageId);

        foreach ($request->sections as $key => $arrayOfContents) {

            $title = $request->section['title'] ?? null;
            $section = SectionRepositoryFacade::create($element->id, $title);

            $order = $page->layouts->count()+ $key +1;

            LayoutRepositoryFacade::create($page, $section->id, $order, 12 / count($request->sections));

            ContentRepositoryFacade::createMultipleContents($section, $arrayOfContents);

        }

        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

}
