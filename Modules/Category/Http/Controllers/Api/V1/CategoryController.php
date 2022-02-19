<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use AliBayat\LaravelCategorizable\Category;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Category\Facades\ResponderFacade;
use Modules\Category\Http\Requests\CreateRequest;
use Modules\Category\Http\Requests\EditRequest;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::where('type','Category')->get()->toTree()->toArray();
        return  ResponderFacade::index($categories);
    }


    public function create(CreateRequest $request)
    {

        if (is_null($request->parent)) {
            Category::create([
                'name' =>$request->name,
                'type' => "Category"
            ]);
        } else {
            Category::create([
                'name' => $request->name,
                'type' => "Category"
            ]);
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

    //check for type of category
    public function filterCategories(Request $request)
    {
        $categories = app(Pipeline::class)

            ->send(Category::query())

            ->through([])

            ->thenReturn()
            ->paginate(7);

        return ResponderFacade::filtercategories($categories);
    }
}
