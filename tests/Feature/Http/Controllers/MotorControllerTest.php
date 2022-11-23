<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Motor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MotorControllerTest extends TestCase
{
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
    public function test_register()
    {
        $response = $this->json('POST', '/api/v1/auth/register', [
            'name' => 'User Test',
            'email' => 'test@gmail.com',
            'password' => 'qwerty123'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function test_login()
    {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => 'test@gmail.com',
            'password' => 'qwerty123'
        ]);

        $response->assertStatus(200);
        return $response->baseResponse->original['token'];
    }

    /**
     * @depends test_login
     */
    public function test_get_all_motor($token)
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', route('motor.index'), []);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_store_motor($token)
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', route('motor.store'), [
            'mesin' => 'Mesin 2 Silinder',
            'tipe_suspensi' => 'Plunger Rear Suspension',
            'tipe_transmisi' => 'AT'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_update_motor($token)
    {
        $motor = Motor::where('mesin', 'Mesin 2 Silinder')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('PUT', route('motor.update', $motor->_id), [
            'mesin' => 'Mesin 2 Silinder',
            'tipe_suspensi' => 'Telescopic Fork',
            'tipe_transmisi' => 'AT'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_delete_motor($token)
    {
        $motor = Motor::where('mesin', 'Mesin 2 Silinder')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('DELETE', route('motor.destroy', $motor->_id), []);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_delete_register_user($token)
    {
        $user = User::where('email', 'test@gmail.com')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('DELETE', route('user.destroy', $user->_id), []);

        $response->assertStatus(200);
    }
}
