<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\ReportInterface;
use App\Interfaces\TransactionInterface;
use App\Models\Kendaraan;
use App\Models\Transaction;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportInterface
{
    public function processGetStok()
    {
        $all = Kendaraan::get()->count();
        $mobil = Kendaraan::where('motor', '!=', null)->count();
        $motor = Kendaraan::where('motor', '!=', null)->count();

        $data = [
            'total_kendaraan' => $all,
            'total_mobil' => $mobil,
            'total_motor' => $motor,
        ];

        return response()->json(['data' => $data, 'status_code' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function processGetPenjualan()
    {
        $all = Transaction::all();
        $mobil = Transaction::where('kendaraan.mobil', '!=', null)->get();
        $motor = Transaction::where('kendaraan.motor', '!=', null)->get();

        $total_all = 0;
        $total_mobil = 0;
        $total_motor = 0;

        foreach ($all as $a) {
            $total_all += $a->kendaraan['harga'];
        }

        foreach ($mobil as $mbl) {
            $total_mobil += $mbl->kendaraan['harga'];
        }

        foreach ($motor as $mtr) {
            $total_motor += $mtr->kendaraan['harga'];
        }

        $data = [
            'total_penjualan_kendaraan' => $total_all,
            'total_penjualan_mobil' => $total_mobil,
            'total_penjualan_motor' => $total_motor,
        ];

        return response()->json(['data' => $data, 'status_code' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function processGetPenjualanKendaraan($payload)
    {
        $transactions = DB::table('transactions')->when($payload, function ($q, $payload) {
            if ($payload['jenis'] == 'motor') {
                $q->where('kendaraan.motor', '!=', null);
            } else if ($payload['jenis'] == 'mobil') {
                $q->where('kendaraan.mobil', '!=', null);
            }
        })->get();

        $total = 0;

        foreach ($transactions as $q) {
            $total += $q['kendaraan']['harga'];
        }

        $data = [
            'jenis' => $payload['jenis'],
            'total_penjualan' => $total,
        ];

        return response()->json(['data' => $data, 'status_code' => Response::HTTP_OK], Response::HTTP_OK);
    }
}
