<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\KendaraanInterface;
use App\Models\Kendaraan;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class KendaraanRepository implements KendaraanInterface
{

    public function getAll()
    {
        $data = Kendaraan::all();
        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    public function storeData($payload)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();
        try {
            Kendaraan::create($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'Kendaraan ditambahkan'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $session->abortTransaction();
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function updateData($payload, $id)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();
        try {
            $table = Kendaraan::find($id);
            $table->update($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'Kendaraan diupdate'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $session->abortTransaction();
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function deleteData($id)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();
        try {
            $user = Kendaraan::find($id);

            if (!$user) return response()->json(['message' => 'ID tidak ada'], Response::HTTP_BAD_REQUEST);

            $user->delete();

            $session->commitTransaction();
            return response()->json(['message' => 'Kendaraan dihapus'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $session->abortTransaction();
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
