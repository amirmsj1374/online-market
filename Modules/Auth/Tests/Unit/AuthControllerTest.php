<?php

namespace Modules\Auth\Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    /**
     * A unit test register user.
     *
     * @return void
     */
    public function test_register_user()
    {
        $user = User::factory()->make();
        $response = $this->postJson(route('auth.register'), [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(201);
    }
    /**
     * A unit test login user.
     *
     * @return void
     */
    public function test_login_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('auth.login'), [
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(200);
    }
    /**
     * A unit test logout user.
     *
     * @return void
     */
    public function test_logout_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->postJson(route('auth.login'), [
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);

        $response = $this->postJson(route('auth.logout'));
        $response->assertStatus(200);
    }
}
