<?php

namespace Modules\Communication\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Communication\Entities\Communication;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;
use Illuminate\Http\Response;
use Modules\Communication\Facades\ResponderFacade;

class CommunicationController extends Controller
{
    
    public function comment(Request $request)
    {
        $comments = $this->attachdatatoComment(Product::find($request->product_id)->communication()->get());
        $product = product::find($request->product_id);
        return  ResponderFacade::comment($comments, $product);
    }

    public function product()
    {
        $products = $this->attachImagetoProduct(Product::latest()->paginate(2));
        return  ResponderFacade::product($products);
    }

    public function store(Request $request, Product $product)
    {

        $request->validate([
            'text' => 'required',
            'comment_id'  => 'required',
        ]);

        auth()->user()->communications()->create([
            'communicationable_id'   =>  $product->id,
            'communicationable_type' =>  get_class($product),
            'approved'         => 1,
            'is_response'      => 1,
            'parent_id'        => $request->comment_id,
            'comment'          => $request->text,
        ]);

        return  ResponderFacade::store();
    }

    public function changeCommentMode(Request $request, Communication $Communication)
    {
        $Communication->update(['approved' => $request->message_id]);
        return  ResponderFacade::changeCommentMode();
    }

    public function delete(Communication $Communication)
    {
        $Communication->delete();
        return  ResponderFacade::delete();
    }

    public function attachImagetoProduct($products)
    {
        foreach ($products as $product) {
            $product['image'] =  $product->getFirstMedia('product-gallery') ?
                $product->getFirstMedia('product-gallery')->getFullUrl() : '';
        }
        return $products;
    }
    public function attachdatatoComment($comments)
    {
        foreach ($comments as  $comment) {
            $comment['name'] = User::find($comment->user_id)->name;
            if ($comment->parent_id != 0) {
                $comment['parent_name'] = User::find($comment->parent_id)->name;
                $comment['parent_comment'] = Communication::find($comment->parent_id)->comment;
            }

            $comment['image'] =  'https://picsum.photos/200/300';
        }
        return $comments;
    }
}
