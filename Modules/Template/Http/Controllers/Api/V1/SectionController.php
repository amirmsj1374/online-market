<?php

namespace Modules\Template\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
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
        $request->validate([
            'section.*.image' => 'required',
            'section.*.body' => 'nullable|string',
            'section.*.link' => 'nullable|string',
            'section.*.buttonLabel' => 'nullable|string',
            'section.*.type' => 'nullable|string'
        ]);

        $section = SectionRepositoryFacade::create($element);

        // add section to  layout
        $page = PageRepositoryFacade::find($request->pageId);

        LayoutRepositoryFacade::create($page, $section->id);

        ContentRepositoryFacade::create($section, $request->section);


        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

    // related to banner-advance
    public function addMultipleSections(Element $element, Request $request)
    {

        // add section to  layout
        $page = PageRepositoryFacade::find($request->pageId);

        foreach ($request->sections as  $arrayOfContents) {

            $section = SectionRepositoryFacade::create($element);

            LayoutRepositoryFacade::create($page, $section->id, 12 / count($request->sections));

            ContentRepositoryFacade::create($section, $arrayOfContents);

        }

        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

}
