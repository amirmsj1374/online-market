<?php

namespace Modules\Template\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Template\Entities\Element;
use Modules\Template\Entities\Page;
use Modules\Template\Entities\Template;
use Illuminate\Support\Facades\Log;
use Modules\Template\Entities\Section;

use function PHPUnit\Framework\isNull;

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

        $sections = collect();
        if ($page->layouts) {
            foreach ($page->layouts as  $layout) {
                $sections->push($layout->section);
            }
        }

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
                'inputs' => $item['inputs'],
            ]);
        }

        return response()->json([
            'message' => 'اطلاعات قالب با موفقیت ذخیره شد'
        ], Response::HTTP_OK);
    }

    public function getIputs(Element $element)
    {

        $data = collect();
        $array = [];
        $inputs = $element->inputs;

        foreach ($inputs as  $input) {
            $array[$input['name']] = null;
        }

        $data->put(0, $array);

        return response()->json([
            'contents' => $data
        ]);
    }
    public function getContentsOfSection(Section $section)
    {

        $data = collect();
        $inputs = $section->element->inputs;

        foreach ($section->contents as $contentKey => $content) {

            $contentWithKey = [];
            foreach ($inputs as  $input) {

                $contentWithKey[$input['name']] = $content->toArray()[$input['name']];
            }

            $data->put($contentKey, $contentWithKey);
        }

        return response()->json([
            'sections' => $data
        ]);
    }

    public function addSection(Element $element, Request $request)
    {
        $request->validate([
            'sections.*.image' => 'required',
            'sections.*.body' => 'nullable|string',
            'sections.*.link' => 'nullable|string',
            'sections.*.buttonLabel' => 'nullable|string'
        ]);

        $section = $element->sections()->create([
            'title' => $element->label,
        ]);

        foreach ($request->sections as  $value) {

            $content = $section->contents()->create([
                'body' => $value['body'] ?? null,
                'buttonLabel' => $value['buttonLabel'] ?? null,
                'customClass' => $value['customClass'] ?? null,
                'cols' => $value['cols'] ?? null,
                'link' => $value['link'] ?? null,
                'order' => $value['order'] ?? null,
                'section_id' => $value['section_id'] ?? null,
                'time' => $value['time'] ?? null,
                'type' => $value['type'] ?? null,
            ]);

            $content->addMedia(public_path(str_replace(config('app.url'), '', $value['image'])))->toMediaCollection('content');
        }

        // add section to  layout
        $page = Page::find($request->pageId);

        $page->layouts()->create([
            'section_id' => $section->id,
            'order' => 2,
        ]);



        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
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
