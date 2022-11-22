<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_register_name_empty()
    {
        $response = $this->json('POST', '/api/v1/auth/register', [
            'name' => '',
            'email' => 'user@gmail.com',
            'password' => 'qwerty123'
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function test_register_pasword_min_6_character()
    {
        $response = $this->json('POST', '/api/v1/auth/register', [
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => '12345'
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function test_register_invalid_email()
    {
        $response = $this->json('POST', '/api/v1/auth/register', [
            'name' => 'User',
            'email' => 'user_gmail.com',
            'password' => '123456'
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function test_register()
    {
        $response = $this->json('POST', '/api/v1/auth/register', [
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => 'qwerty123'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function test_exist_user()
    {
        $response = $this->json('POST', '/api/v1/auth/register', [
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => 'qwerty123'
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function test_login()
    {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => 'user@gmail.com',
            'password' => 'qwerty123'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function test_logout()
    {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => 'user@gmail.com',
            'password' => 'qwerty123'
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $response->baseResponse->original['token'])->json('POST', '/api/v1/auth/logout');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_delete_user()
    {
        $response = $this->json('POST', '/api/v1/auth/user/delete', [
            'email' => 'user@gmail.com'
        ]);

        $response->assertStatus(204);
    }
}
