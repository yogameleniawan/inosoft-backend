<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Interfaces\MobilInterface;
use App\Models\Mobil;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MobilRepository implements MobilInterface
{

    public function getAll()
    {
        $data = Mobil::all();
        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    public function storeData($payload)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();
        try {
            Mobil::create($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'Mobil ditambahkan'], Response::HTTP_OK);
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
            $table = Mobil::find($id);
            $table->update($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'Mobil diupdate'], Response::HTTP_OK);
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
            $user = Mobil::find($id);

            if (!$user) return response()->json(['message' => 'ID tidak ada'], Response::HTTP_BAD_REQUEST);

            $user->delete();

            $session->commitTransaction();
            return response()->json(['message' => 'Mobil dihapus'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $session->abortTransaction();
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
