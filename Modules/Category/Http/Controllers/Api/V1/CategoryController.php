<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use AliBayat\LaravelCategorizable\Category;
use Illuminate\Routing\Controller;
use Modules\Category\Facades\ResponderFacade;
use Modules\Category\Http\Requests\CreateRequest;
use Modules\Category\Http\Requests\EditRequest;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::tree();
        return  ResponderFacade::index($categories);
    }


    public function create(CreateRequest $request)
    {

        if (is_null($request->parent)) {
            Category::create(['name' => $request->name]);
        } else {
            Category::create(['name' => $request->name]);
            $parent = Category::findById($request->parent);
            $child = Category::findByName($request->name);
            $parent->appendNode($child);
        }

        return  ResponderFacade::getAllCategory();
    }



    public function edit(EditRequest $request)
    {

        $category = Category::findById($request->id);

        if ($category->count() > 0) {

            $category->update([
                'name' => $request->name
            ]);

            return  ResponderFacade::getAllCategory();
        }

        return  ResponderFacade::editFailed();
    }


    public function destroy($id)
    {
        $category = Category::findById($id);

        if ($category->count() > 0) {

            $category->delete();

            return  ResponderFacade::getAllCategory();
        } else {

            return  ResponderFacade::destroyFailed();
        }
    }
}
