<?php

namespace Modules\User\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery;
use Modules\User\Entities\User;
use Modules\User\Http\Controllers\UserController;

class UserControllerTest extends TestCase
{

    public function create_user($user)
    {
        $response = $this->postJson(route('user.create'), [
            'name'     => $user->name,
            'email'    => $user->email,
            'password' => 'password',
            'role'     => 'admin',
            'status'   => 1
        ]);

        $response->assertStatus(201);
    }

    public function update_user($oldFakeUser)
    {
        $oldUser = User::where('email', $oldFakeUser->email)->first();
        $newFakeUser = User::factory()->make();
        $response = $this->postJson(route('user.update', $oldUser->id), [
            'name'     => $newFakeUser->name,
            'email'    => $newFakeUser->email,
            'password' => 'password',
            'role'     => 'admin',
            'status'   => 1
        ]);
        $response->assertStatus(200);
    }

    public function test_performanceـofـtheـuserـmodule()
    {
        $user = User::factory()->make();
        $this->create_user($user);
        $this->update_user($user);
    }
}
