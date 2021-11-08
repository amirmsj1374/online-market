<?php

namespace Modules\Communication\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Communication\Entities\Communication;

class CommunicationController extends Controller
{
    public function index()
    {
        $Communications = Communication::where('approved', 1)->latest()->paginate(20);      
    }

    public function unapproved()
    {
        $Communications = Communication::where('approved', 0)->latest()->paginate(20);
    }

    public function show($id)
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Communicationid' => 'required',
            'responce'  => 'required',
        ]);
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
}
