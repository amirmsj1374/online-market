<?php

namespace Modules\Communication\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Communication\Entities\Communication;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;

class CommunicationController extends Controller
{
    public function comment(Request $request)
    {
        $comments = $this->attachdatatoComment(Product::find($request->product_id)->communication()->get());
        // Log::info([
        //     'comments' => $comments,
        // ]);

        return response()->json([
            'comments' => $comments,
            'user_id' => auth()->id()
        ]);
    }
    public function product()
    {
        $products = $this->attachImagetoProduct(Product::latest()->paginate(2));

        return response()->json([
            'products' => $products
        ]);
    }

    public function unapproved()
    {
        $Communications = Communication::where('approved', 0)->latest()->paginate(20);
    }

    public function show($id)
    {
        //
    }

    public function store(Request $request, Product $product)
    {
        Log::info([
            'request' => $request->all()
        ]);
        // $data = $request->validate([
        //     'Communicationid' => 'required',
        //     'responce'  => 'required',
        // ]);
        $Communication = Communication::Find($data['Communicationid']);

        auth()->user()->Communications()->create([
            'Communicationable_id'   => $Communication->Communicationable_id,
            'Communicationable_type' => $Communication->Communicationable_type,
            'approved'         => 1,
            'is_response'      => 1,
            'parent_id'        => $Communication->id,
            'Communication'          => $data['responce'],
        ]);

        $Communication->update([
            'is_response' => 1
        ]);


    }

    public function update(Request $request, Communication $Communication)
    {
        $Communication->update(['approved' => 1]);
        return response()->json([
            'message' => 'متن نظر تایید شد',
        ]);
    }


    public function destroy(Communication $Communication)
    {
        $Communication->delete();
        return response()->json([
            'message' => 'متن نظر حذف شد',
        ]);
    }

    public function attachImagetoProduct($products)
    {
        foreach ($products as $key => $product) {
            $product['image'] =  $product->getFirstMedia('product-gallery') ?
            $product->getFirstMedia('product-gallery')->getFullUrl() : '';
        }
        return $products;
    }
    public function attachdatatoComment($comments)
    {
        foreach ($comments as $key => $comment) {
            $comment['name'] = User::find($comment->user_id)->name;
            $comment['image'] =  'https://picsum.photos/200/300';
        }
        return $comments;
    }
}
