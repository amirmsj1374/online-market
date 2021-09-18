<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\User\Facades\ResponderFacade;
use Modules\User\Http\Requests\UserRequest;
use Illuminate\Pipeline\Pipeline;
use Modules\User\QueryFilter\Mobile;
use Modules\User\QueryFilter\Name;
use Modules\User\QueryFilter\Type;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $users = app(Pipeline::class)

            ->send(User::query())

            ->through([
                Type::class,
                Mobile::class,
                Name::class
            ])

            ->thenReturn()
            ->with('profile')
            ->paginate(2);

        return ResponderFacade::index($users);
    }

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

    public function show(User $user)
    {
        return ResponderFacade::show($user);
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
