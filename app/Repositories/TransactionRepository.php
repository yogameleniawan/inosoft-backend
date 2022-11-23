<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\TransactionInterface;
use App\Models\Transaction;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionInterface
{

    public function getAll()
    {
        $data = Transaction::all();
        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    public function storeData($payload)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();
        try {
            Transaction::create($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'Transaction ditambahkan'], Response::HTTP_OK);
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
            $table = Transaction::find($id);

            if (!$table) return response()->json(['message' => 'ID tidak ada'], Response::HTTP_BAD_REQUEST);

            $table->update($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'Transaction diupdate'], Response::HTTP_OK);
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
            $table = Transaction::find($id);

            if (!$table) return response()->json(['message' => 'ID tidak ada'], Response::HTTP_BAD_REQUEST);

            $table->delete();

            $session->commitTransaction();
            return response()->json(['message' => 'Transaction dihapus'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $session->abortTransaction();
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
