<?php

namespace App\Interfaces;

use Illuminate\Support\Facades\Request;

interface KendaraanInterface
{
    public function getAll();

    public function storeData($payload);

    public function updateData($payload, $id);

    public function deleteData($id);
}
