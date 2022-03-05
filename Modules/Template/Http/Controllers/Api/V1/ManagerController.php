<?php

namespace Modules\Template\Http\Controllers\Api\V1;



use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Template\Entities\Element;
use Modules\Template\Entities\Layout;
use Modules\Template\Entities\Page;
use Modules\Template\Entities\Template;
use Modules\Template\Entities\Section;


class ManagerController extends Controller
{
    public function getAllTemplates()
    {
        $result = $this->dataTemplates();

        return response()->json([
            'templates' => $result['templates'],
            'selectedTemplate' => $result['selectedTemplate']
        ], Response::HTTP_OK);
    }

    public function addNewTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:20000'
        ]);

        $template = Template::create([
            'name' => $request->name,
        ]);

        if (Template::count() == 1) {
            $template->update([
                'selected' => 1
            ]);
        }


        $template->addMedia($request->image)->toMediaCollection('template');

        return response()->json([
            'message' => 'قالب جدید اضاف شد',
            'template' => $template->id
        ], Response::HTTP_OK);
    }

    public function selectTemplate(Template $template, Request $request)
    {
        $selected = Template::where('selected', 1)->first()->update([
            'selected' => 0
        ]);

        $template->update([
            'selected' => $request->status
        ]);

        $result = $this->dataTemplates();

        return response()->json([
            'message' => 'قالب ' . $template->name . ' فعال شد.',
            'templates' => $result['templates'],
            'selectedTemplate' => $result['selectedTemplate']
        ], Response::HTTP_OK);
    }

    public function addPage(Template $template, Request $request)
    {
        $request->validate([
            'name'  => 'required|min:4',
            'label' => 'required|min:4',
            'icon'  => 'nullable|min:4',
        ]);

        $template->pages()->create([
            'name'  => $request->name,
            'label' => $request->label,
            'icon'  => $request->icon,
        ]);

        return response()->json([
            'message' => 'صفحه جدید اضافه شد',
            'pages' => $template->pages
        ], Response::HTTP_OK);
    }

    public function deletePage(Page $page, Request $request)
    {

        $page->delete();
        $pages = Template::find($request->template_id)->pages;
        return response()->json([
            'message' => 'صفحه مورد نظر حذف شد',
            'pages' => $pages
        ], Response::HTTP_OK);
    }

    public function getPages()
    {

        $template = Template::where('selected', 1)->first();
        return response()->json([
            'pages' => $template->pages
        ], Response::HTTP_OK);
    }

    public function getAllElements(Template $template)
    {
        $elements = $this->addMediaToModel($template->elements, 'element');
        return response()->json([
            'elements' => $elements
        ], Response::HTTP_OK);
    }

    public function getSectionOfPage(Page $page)
    {
        $sections = $page->layouts->groupBy('row')->map(function ($q) {
            return $q->first()->section;
        });

        return response()->json([
            'sections' => $sections
        ], Response::HTTP_OK);
    }

    public function addElements(Template $template, Request $request)
    {

        $request->validate([
            '*.name' => 'required|min:4',
            '*.icon_address' => 'required',
            '*.type' => 'required|string'
        ]);

        foreach ($request->all() as $item) {

            $template->elements()->create([
                'name'  => $item['name'],
                'label' => $item['label'],
                'type' => $item['type'],
                'description' => $item['description'],
                'icon_address' => $item['icon_address']['address'],
            ]);
        }

        return response()->json([
            'message' => 'اطلاعات قالب با موفقیت ذخیره شد'
        ], Response::HTTP_OK);
    }



    public function getContentsOfSection(Section $section, Request $request)
    {

        $contents = Layout::where('page_id', $request->page_id)->where('row', $section->layout->row)->get()
        ->map(function ($q) {
            return $q->section->contents;
        });

        return response()->json([
            'sections' => $contents
        ]);
    }

    public function dataTemplates()
    {
        $templates = $this->addMediaToModel(Template::get(), 'template');

        $selectedTemplate = $templates->where('selected', 1)->first();

        return [
            'templates'        => $templates,
            'selectedTemplate' => $selectedTemplate,
        ];
    }

    public function addMediaToModel($data, $gallary)
    {
        foreach ($data as $item) {
            $images = [];
            if ($item->getFirstMedia($gallary)) {
                foreach ($item->getMedia($gallary) as $key => $image) {
                    $images[$key] = $image->getFullUrl();
                }
            }
            $item['images'] =  $images;
        }

        return $data;
    }
}
