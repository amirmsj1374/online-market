<?php

namespace Modules\Auth\Tests\Feature;

use Modules\User\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    /**
     * register user.
     *
     * @return void
     */
    public function register_user($user)
    {
        $response = $this->postJson(route('auth.register'), [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(201);
    }
    /**
     * login user.
     *
     * @return void
     */
    public function login_user($user)
    {
        $response = $this->actingAs($user)->postJson(route('auth.login'), [
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(200);
    }
    /**
     * logout user.
     *
     * @return void
     */
    public function logout_user($user)
    {
        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(200);
    }

    /**
     * forgot password.
     *
     * @return void
     */
    public function forgot_password($user)
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('auth.forgot.password'), [
            'email' => $user->email,
        ]);

        $response->assertStatus(200);
        // $this->assertEquals($response->getStatusCode(), 200);
    }

    /**
     * A feature test for test performance of the authentication system.
     *
     * @return void
     */
    public function test_performanceـofـtheـauthenticationـsystem()
    {

        $user = User::factory()->make();
        $this->register_user($user);
        $this->login_user($user);
        $this->logout_user($user);
        $this->forgot_password($user);
    }
}
