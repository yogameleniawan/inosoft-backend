<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Interfaces\MotorInterface;
use App\Models\Motor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MotorRepository implements MotorInterface
{

    public function getAll()
    {
        $data = Motor::all();
        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    public function storeData($payload)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();
        try {
            Motor::create($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'Motor ditambahkan'], Response::HTTP_OK);
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
            $table = Motor::find($id);
            $table->update($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'Motor diupdate'], Response::HTTP_OK);
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
            $user = Motor::find($id);

            if (!$user) return response()->json(['message' => 'ID tidak ada'], Response::HTTP_BAD_REQUEST);

            $user->delete();

            $session->commitTransaction();
            return response()->json(['message' => 'Motor dihapus'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $session->abortTransaction();
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
