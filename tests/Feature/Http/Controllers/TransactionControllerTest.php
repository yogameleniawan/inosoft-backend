<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
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
    public function test_get_all_transaction($token)
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', route('transaction.index'), []);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_store_transaction($token)
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', route('transaction.store'), [
            'kendaraan' => 'Kendaraan1'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_update_transaction($token)
    {
        $transaction = Transaction::where('kendaraan', 'Kendaraan1')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('PUT', route('transaction.update', $transaction->_id), [
            'kendaraan' => 'Kendaraan2'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @depends test_login
     */
    public function test_delete_transaction($token)
    {
        $transaction = Transaction::where('kendaraan', 'Kendaraan2')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('DELETE', route('transaction.destroy', $transaction->_id), []);

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
