<?php

namespace Modules\Template\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Template\Entities\Content;
use Modules\Template\Entities\Element;
use Modules\Template\Entities\Layout;
use Modules\Template\Entities\Page;
use Modules\Template\Entities\Section;
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
            ],
        [
            'section.*.image' => 'فیلد تصویر الزامی است.',
        ]);
        }

        $request->validate(
        [
            'section' => 'array|min:1',
            'section.*.body' => 'nullable|string',
            'section.*.link' => 'nullable|string',
            'section.*.buttonLabel' => 'nullable|string',
            'section.*.type' => 'nullable|string'
        ],
        [
            'section.*.body.string' => 'فیلد متن باید رشته باشد.',
            'section.*.link.string' => 'فیلد لینک باید رشته باشد.',
            'section.*.buttonLabel.string' => 'فیلد عنوان دکمه باید رشته باشد.',
            'section.*.type.string' => 'نوع باید رشته باشد.',
        ]);


        $title = $request->section['title'] ?? null;

        $section = SectionRepositoryFacade::create($element->id, $title);

        // // add section to  layout
        $page = PageRepositoryFacade::find($request->pageId);
        $order = $page->layouts->count()+ 1;

        LayoutRepositoryFacade::create($page, $section->id, $order);

        if (str_contains($element->type, 'slider') || str_contains($element->type, 'banner')) {

            foreach ($request->section as $item) {

                ContentRepositoryFacade::createMultipleContents($section, $item);

            }

        }



        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

    public function addContent(Element $element, Request $request)
    {
        if (empty($request->section['categories'])) {
            $request->validate([
               'section.products'     =>  'required|array|min:1',
            ]);
        } else {
            $request->validate([
               'section.categories'   =>  'required|array|min:1',
            ]);
        }

        $title = $request->section['title'] ?? null;

        $section = SectionRepositoryFacade::create($element->id, $title);

        // // add section to  layout
        $page = PageRepositoryFacade::find($request->pageId);
        $order = $page->layouts->count()+ 1;

        LayoutRepositoryFacade::create($page, $section->id, $order);

        ContentRepositoryFacade::createContent($section, $request->section);

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

            foreach ($arrayOfContents as $item) {
                ContentRepositoryFacade::createMultipleContents($section, $item);
            }

        }

        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

    public function updateSection(Section $section, Request $request)
    {

         // vlidation for slider or banner type
         if (str_contains($section->element->type, 'slider') || str_contains($section->element->type, 'banner')) {
            $request->validate([
                'section.*.image' => 'required',
            ],
        [
            'section.*.image' => 'فیلد تصویر الزامی است.',
        ]);
        }


        $request->validate(
            [
                'section' => 'array|min:1',
                'section.*.body' => 'nullable|string',
                'section.*.link' => 'nullable|string',
                'section.*.buttonLabel' => 'nullable|string',
                'section.*.type' => 'nullable|string'
            ],
            [
                'section.*.body.string' => 'فیلد متن باید رشته باشد.',
                'section.*.link.string' => 'فیلد لینک باید رشته باشد.',
                'section.*.buttonLabel.string' => 'فیلد عنوان دکمه باید رشته باشد.',
                'section.*.type.string' => 'نوع باید رشته باشد.',
            ]);

        $contentIds = $section->contents->pluck('id')->toArray();

        foreach ($request->section as $item) {
            if (array_key_exists('section_id', $item) && $item['section_id']) {

                $remainingContentIds[] = $item['id'] ;

                $content = ContentRepositoryFacade::find($item['id']);

                ContentRepositoryFacade::update($content, $item);

            } else {
                ContentRepositoryFacade::createMultipleContents($section, $item);
            }
        }

        foreach (array_diff($contentIds, $remainingContentIds) as $id) {
            ContentRepositoryFacade::delete($id);
        }

        return response()->json([
            'message' => 'ویرایش با موفقیت انجام شد.'
        ], Response::HTTP_OK);

    }

    public function updateContent(Content $content,Request $request) {

        if (empty($request->section['categories'])) {
            $request->validate([
               'section.products'     =>  'required|array|min:1',
            ]);
        } else {
            $request->validate([
               'section.categories'   =>  'required|array|min:1',
            ]);
        }

        $section = SectionRepositoryFacade::find($content->section_id);

        SectionRepositoryFacade::update($section, [ 'title' => $request->section['title']]);

        ContentRepositoryFacade::updateProductContent($content, $request->section);

        return response()->json([
            'message' => 'ویرایش با موفقیت انجام شد.'
        ], Response::HTTP_OK);
    }

    public function updateMultipleSections(Request $request)
    {
        $row = 3;
        $page_id = 3;
        $layoutIds = [21, 22];

        Layout::where('page_id', $page_id)->where('row' > $row)->get()->map(function ($layout)use($layoutIds, $request) {
            $layout->order  = $layout->order + count($request->sections) - count($layoutIds);
            $layout->save();
        });

        $order = Layout::where('page_id', $page_id)->where('row' > $row)->first()->order;
        foreach ($layoutIds as $key => $id) {
            $section = Layout::find($id)->section;
            $element_id = $section->element_id;
            $section->delete();
        }

        $page = PageRepositoryFacade::find($page_id);

        foreach ($request->sections as $key => $arrayOfContents) {

            $title = $request->section['title'] ?? null;
            $section = SectionRepositoryFacade::create($element_id, $title);

            $page->layouts()->create([
                'section_id' => $section->id,
                'order'      => $order + $key,
                'row'        => $row,
                'col'        => $col
            ]);

            foreach ($arrayOfContents as $item) {
                ContentRepositoryFacade::createMultipleContents($section, $item);
            }

        }

        return response()->json([
            'message' => 'ویرایش با موفقیت انجام شد.'
        ], Response::HTTP_OK);

    }

    public function deleteSection(Section $section)
    {
        Log::info(['id',$section]);
        SectionRepositoryFacade::delete($section);

        return response()->json([
            'message' => 'قسمت با موفقیت حذف شد.'
        ], Response::HTTP_OK);
    }


    public function orderSections(Page $page, Request $request)
    {

        Log::info([
            'row' => $request->sections
        ]);
        $rows = [];
        foreach ($request->sections as $section) {
            array_push($rows, $section['row']);
        }

        $groups = $page->layouts->groupBy('row');

        foreach ($groups as $group) {
            foreach ($group as $key => $layout) {
                $key = array_search($layout->row, $rows);
                $layout->update([
                    'row' => $key + 1
                ]);
            }
        }



        return response()->json([
            'message' => 'قسمت با موفقیت حذف شد.'
        ], Response::HTTP_OK);
    }

}
