<?php

namespace Modules\Template\Http\Controllers\Api\V1;

// use AliBayat\LaravelCategorizable\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Category\Http\Helper\Category;
use Modules\Template\Entities\Element;
use Modules\Template\Entities\Page;

class MenuController extends Controller
{

    public function showMenu()
    {
        $menuItem = Category::where('type', 'Menu')->orWhere('status', '1')->get()->toTree()->toArray();

        return response()->json([
            'menuItem' => $menuItem
        ], Response::HTTP_OK);
    }



    public function addMenu(Request $request)
    {

        Log::info(['data' => $request->all()]);

        if ($request->menuItem['type'] === 'category') {
            $category = Category::findById($request->menuItem['category_id']);

            Category::create([
                'name' =>  $category->name,
                'link' =>  $category->slug,
                'type' => "Menu",
                'status' => 1,
                'child' => $category->id,
            ]);
        } else if ($request->menuItem['type'] === 'link') {

            Category::create([
                'name' => $request->menuItem['name'],
                'link' => $request->menuItem['link'],
                'type' => "Menu",
                'status' => 1,
            ]);
        }

        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

    public function addSubmenu(Request $request)
    {



        if ($request->menuItem['type'] === 'category') {


            $category = Category::findById($request->menuItem['category_id']);

            $childId =  Category::create([
                'name' =>  $category->name,
                'link' =>  $category->slug,
                'type' => "Menu",
                'status' => 1,
                'child' => $category->id,
            ]);
        } else if ($request->menuItem['type'] === 'link') {

            $childId = Category::create([
                'name' => $request->menuItem['name'],
                'link' => $request->menuItem['link'],
                'type' => "Menu",
                'status' => 1,
            ]);
        }



        $parent = Category::findById($request->menuItem['parent']);
        $child = Category::findById($childId->id);
        $parent->appendNode($child);

        return response()->json([
            'message' => 'دسته  بندی به منو افزوده شد'
        ], Response::HTTP_OK);
    }

    public function updateMenu(Request $request)
    {

        $menuItem = Category::findById($request->menuItem['parent']);

        $menuItem->update([
            'name' => $request->menuItem['name'],
        ]);

        return response()->json([
            'message' => 'بخش جدید به صفحه ویرایش شد'
        ], Response::HTTP_OK);
    }

    public function chnageStatus(Request $request)
    {
        $menuItem = Category::findById($request->id);
        $menuItem->update([
            'status' => $menuItem->status == '1' ? '0' : '1',
        ]);

        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }

    // shoud not remove category item just chnage menu status => 2
    public function deleteMenu(Request $request)
    {
        $menuItem = Category::findById($request->id);

        if ($menuItem->count() > 0 && $menuItem->type != 'Category') {

            $menuItem->delete();
        } else {
            $menuItem->update([
                'status' => 2,
            ]);
        }
        return response()->json([
            'message' => 'بخش جدید به صفحه حذف شد'
        ], Response::HTTP_OK);
    }

    public function addSection(Element $element, Request $request)
    {

        $request->validate([
            'section.*.image' => 'nullable',
            'section.*.message' => 'nullable|string',
        ]);

        $section = $element->sections()->create([
            'title' => $element->label,
        ]);

        // add section to  layout
        $page = Page::find($request->pageId);

        $page->layouts()->create([
            'section_id' => $section->id,
            'order' => 1,
        ]);

        $content = $section->contents()->create([
            'body' => $request->message,
        ]);

        $content->addMedia($request->image)
            ->toMediaCollection('content');

        return response()->json([
            'message' => 'بخش جدید به صفحه اضافه شد'
        ], Response::HTTP_OK);
    }
}
