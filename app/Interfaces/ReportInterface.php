<?php

namespace App\Interfaces;

use Illuminate\Support\Facades\Request;

interface ReportInterface
{
    public function processGetStok();

    public function processGetPenjualan();

    public function processGetPenjualanKendaraan($payload);
}
