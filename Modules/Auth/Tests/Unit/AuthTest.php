<?php

namespace Modules\Auth\Tests\Unit;

use Modules\User\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{

    public function test_register_user()
    {
        $user = User::factory()->make();
        $response = $this->postJson(route('auth.register'), [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(200);
    }

    public function test_login_user()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('auth.login'), [
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(200);
    }

    public function test_logout_user()
    {
        $user = User::factory()->create();
        $this->postJson(route('auth.login'), [
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);

        $response = $this->postJson(route('auth.logout'));
        $response->assertStatus(200);
    }
}
