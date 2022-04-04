<?php

namespace Modules\Article\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Modules\Article\Entities\Article;
use Modules\Article\QueryFilter\Title;


class ArticleController extends Controller
{

    public function filter(Request $request)
    {

        $products = app(Pipeline::class)

            ->send(Article::query())

            ->through([
                Title::class,
            ])

            ->thenReturn()
            ->paginate($request->per_page);

        return $products;
    }

    public function create(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string',
            'status.status' => 'required|boolean',
            'description' => 'nullable',
            'tag' => 'required',
            'body' => 'required',
        ]);


        $article =  Article::create([
            'name' => $request->name,
            'status' => $request->status['status'],
            'description' => $request->description,
            'body' => $request->body,
        ]);


        $article->syncTags($request->tag);



        return response()->json([
            'message' => 'اطلاعات صفحه جدید ثبت شد'
        ], Response::HTTP_OK);
    }

    public function show(Article $article)
    {
        $article['tag'] = $article->tags->pluck('name');
        return response()->json(['data' => $article]);
    }

    public function update(Request $request, Article $article)
    {

        $data = $request->validate([
            'name' => 'required|string',
            'status.status' => 'required|boolean',
            'description' => 'nullable',
            'tag' => 'required',
            'body' => 'required',
        ]);


        $article->update([
            'name' => $request->name,
            'status' => $request->status['status'],
            'description' => $request->description,
            'body' => $request->body,
        ]);


        $article->syncTags($request->tag);



        return response()->json([
            'message' => 'اطلاعات صفحه جدید ویرایش شد'
        ], Response::HTTP_OK);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json([
            'message' => 'اطلاعات صفحه جدید حذف  شد'
        ], Response::HTTP_OK);
    }
}