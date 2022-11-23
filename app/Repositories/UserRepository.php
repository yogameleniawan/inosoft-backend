<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{

    public function getAll()
    {
        $data = User::all();
        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    public function storeData($payload)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();
        try {
            User::create($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'User ditambahkan'], Response::HTTP_OK);
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
            $table = User::find($id);

            if (!$table) return response()->json(['message' => 'ID tidak ada'], Response::HTTP_BAD_REQUEST);

            $table->update($payload);

            $session->commitTransaction();
            return response()->json(['message' => 'User diupdate'], Response::HTTP_OK);
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
            $user = User::find($id);

            if (!$user) return response()->json(['message' => 'ID tidak ada'], Response::HTTP_BAD_REQUEST);

            $user->delete();

            $session->commitTransaction();
            return response()->json(['message' => 'User dihapus'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $session->abortTransaction();
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
