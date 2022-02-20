<?php

namespace Modules\Template\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Template\Entities\Element;
use Modules\Template\Entities\Page;
use Modules\Template\Facades\ContentRepositoryFacade;
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
        $page = Page::find($request->pageId);

        $page->layouts()->create([
            'section_id' => $section->id,
            'order' => 2,
        ]);

        ContentRepositoryFacade::create($section, $request->section);


        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

    // related to banner-advance
    public function addMultipleSections(Element $element, Request $request)
    {

        // add section to  layout
        $page = Page::find($request->pageId);

        foreach ($request->sections as  $arrayOfContents) {
            $section = SectionRepositoryFacade::create($element);

            $order = $page->layouts->count() + 1;

            $page->layouts()->create([
                'section_id' => $section->id,
                'col'        => 12 / count($request->sections),
                'order'      => $order,
            ]);

            ContentRepositoryFacade::create($section, $arrayOfContents);

        }

        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

}
