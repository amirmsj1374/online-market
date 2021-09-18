<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\User;
use Modules\User\Facades\ResponderFacade;
use Modules\User\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
       return ResponderFacade::index();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(UserRequest $request)
    {
        $user = User::create([
            'email'    => $request->email,
            'mobile'   => $request->mobile,
            'name'     => $request->name,
            'password' => $request->password,
            'status'   => $request->status,
        ]);

        $user->profile()->create([
            'address'  => $request->address,
            'city'     => $request->city,
            'phone'    => $request->phone,
            'province' => $request->province,
        ]);


        return ResponderFacade::createUserSuccess();

    }



    public function show($id)
    {
       //...
    }




    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'email'    => $request->email,
            'mobile'   => $request->mobile,
            'name'     => $request->name,
            'password' => $request->password,
            'status'   => $request->status,
        ]);

        $user->profile->update([
            'address'  => $request->address,
            'city'     => $request->city,
            'phone'    => $request->phone,
            'province' => $request->province,
        ]);

        return ResponderFacade::updateUserSuccess();

    }


    public function destroy(User $user)
    {
        $user->delete();
        return ResponderFacade::destroyUserSuccess();
    }
}
