<?php

namespace Modules\Template\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Category\Http\Helper\Category;
use Modules\Template\Entities\Element;
use Modules\Template\Entities\Header;

class HeaderController extends Controller
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

    public function showHeader()
    {
        $header =  Header::first();
        return response()->json([
            'header' => $header
        ], Response::HTTP_OK);
    }

    public function addHeader(Request $request)
    {

        $request->validate([
            'section.*.notification' => 'nullable|string',
            'section.*.link' => 'nullable|string',
            'section.*.siteTitle' => 'nullable|string',
            'section.*.PhoneNumber' => 'nullable|string',
        ]);


        Header::updateOrCreate(
            ['id' => 1],
            [
                'notification' => $request->notification,
                'link' => $request->link,
                'siteTitle' => $request->siteTitle,
                'PhoneNumber' => $request->PhoneNumber,
            ]
        );

        return response()->json([
            'message' => 'اطلاعات هدر صفحه بروز رسانی شد'
        ], Response::HTTP_OK);
    }
}