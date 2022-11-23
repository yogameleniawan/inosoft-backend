<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Mobil;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MobilControllerTest extends TestCase
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
    public function test_get_all_mobil($token)
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', route('mobil.index'), []);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_store_mobil($token)
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', route('mobil.store'), [
            'mesin' => 'Mesin Turbo 4 Silinder 2000CC',
            'kapasitas_penumpang' => 8,
            'tipe' => 'APV'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_update_mobil($token)
    {
        $mobil = Mobil::where('mesin', 'Mesin Turbo 4 Silinder 2000CC')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('PUT', route('mobil.update', $mobil->_id), [
            'mesin' => 'Mesin Turbo 4 Silinder 2000CC',
            'kapasitas_penumpang' => 8,
            'tipe' => 'MPV'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_delete_mobil($token)
    {
        $mobil = Mobil::where('mesin', 'Mesin Turbo 4 Silinder 2000CC')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('DELETE', route('mobil.destroy', $mobil->_id), []);

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
