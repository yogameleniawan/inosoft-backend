<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KendaraanControllerTest extends TestCase
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
    public function test_get_all_kendaraan($token)
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', route('kendaraan.index'), []);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_store_kendaraan($token)
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', route('kendaraan.store'), [
            'tahun_keluaran' => '2022',
            'warna' => 'Hitam',
            'harga' => 21000000
        ]);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_update_kendaraan($token)
    {
        $kendaraan = Kendaraan::where('tahun_keluaran', '2022')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('PUT', route('kendaraan.update', $kendaraan->_id), [
            'tahun_keluaran' => '2022',
            'warna' => 'Putih',
            'harga' => 21000000
        ]);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_delete_kendaraan($token)
    {
        $kendaraan = Kendaraan::where('tahun_keluaran', '2022')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('DELETE', route('kendaraan.destroy', $kendaraan->_id), []);

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
