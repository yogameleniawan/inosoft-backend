<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ReportInterface;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $interface;

    public function __construct(ReportInterface $reportInterface)
    {
        $this->interface = $reportInterface;
    }
    public function getStok()
    {
        return $this->interface->processGetStok();
    }

    public function getPenjualan()
    {
        return $this->interface->processGetPenjualan();
    }

    public function getPenjualanKendaraan(Request $request)
    {
        return $this->interface->processGetPenjualanKendaraan($request->all());
    }
}
