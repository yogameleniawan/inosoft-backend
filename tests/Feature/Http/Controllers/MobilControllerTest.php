<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Mobil;
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

    // /** @test */
    // public function test_get_all_mobil()
    // {
    //     $response = $this->json('GET', route('mobil.index'), []);

    //     $response->assertStatus(200);
    // }

    // /** @test */
    // public function test_store_mobil()
    // {
    //     $response = $this->json('POST', route('mobil.store'), [
    //         'mesin' => 'Mesin Turbo 4 Silinder 2000CC',
    //         'tipe_suspensi' => 'Suspensi Double Wishbone',
    //         'tipe_transmisi' => 'AT'
    //     ]);

    //     $response->assertStatus(200);
    // }

    // /** @test */
    // public function test_update_mobil()
    // {
    //     $mobil = Mobil::where('mesin', 'Mesin Turbo 4 Silinder 2000CC')->first();
    //     $response = $this->json('PUT', route('mobil.update', $mobil->_id), [
    //         'mesin' => 'Mesin Turbo 4 Silinder 2000CC',
    //         'tipe_suspensi' => 'Suspensi Double Wishbone',
    //         'tipe_transmisi' => 'Automatic'
    //     ]);

    //     $response->assertStatus(200);
    // }

    // /** @test */
    // public function test_delete_mobil()
    // {
    //     $mobil = Mobil::where('mesin', 'Mesin Turbo 4 Silinder 2000CC')->first();
    //     $response = $this->json('DELETE', route('mobil.destroy', $mobil->_id), []);

    //     $response->assertStatus(200);
    // }
}
