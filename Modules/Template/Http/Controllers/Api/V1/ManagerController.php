<?php

namespace Modules\Template\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Template\Entities\Element;
use Modules\Template\Entities\Page;
use Modules\Template\Entities\Template;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;
use Modules\Template\Entities\ElementType;

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

    public function getElementsOfPage(Page $page)
    {

        if ($page->layout) {
            $elements = $this->addMediaToModel($page->layout->elements, 'element');
        } else {
            $elements = collect();
        }

        return response()->json([
            'elements' => $elements
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

    public function getContents(Element $element)
    {
        $data = collect();
        $array = [];
        $inputs = $element->inputs;

        if (is_null($element->sections) || $element->sections->isEmpty()) {
            foreach ($inputs as $key => $input) {
                $array[$input['name']] = null;
            }
            $data->put(0, $array);
        } else {
            foreach ($element->sections as $section) {
                foreach ($section->contents as $content) {
                    foreach ($inputs as $key => $input) {
                        $data->put($input['name'], $content->get($input['name']));
                    }
                }
            }
        }

        return response()->json([
            'contents' => $data
        ]);
    }


    public function addSection(Element $element, Request $request)
    {

        Log::info([
            'sec' => $request->sections,
        ]);
        $request->validate([
            'sections.*.image' => 'required',
            'sections.*.body' => 'nullable|string',
            'sections.*.link' => 'nullable|string',
            'sections.*.buttonLabel' => 'nullable|string'
        ]);


        foreach ($request->sections as $key => $value) {

            Log::info([
                'sect' => $value,
            ]);

            $section = $element->sections()->create([
                'title' => $element->label,
            ]);

            $content = $section->contents()->create($value);

            $content->addMediaFromUrl($value->image)->toMediaCollection('content');
        }

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
