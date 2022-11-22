<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dibuat',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kredensial Login tidak valid.',
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (JWTException $e) {
            return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat membuat token',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'type' => 'bearerToken',
        ]);
    }

    public function logout(Request $request)
    {
        if (!$request->bearerToken()) {
            return response()->json(['message' => 'Bearer Token tidak ada'], Response::HTTP_BAD_REQUEST);
        }

        try {
            JWTAuth::invalidate($request->bearerToken());

            return response()->json([
                'success' => true,
                'message' => 'User berhasil logout'
            ], Response::HTTP_OK);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak berhasil logout'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUser(Request $request)
    {
        $user = JWTAuth::user();

        return response()->json(['user' => $user], Response::HTTP_OK);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => JWTAuth::user(),
            'authorization' => [
                'token' => JWTAuth::refresh(),
                'type' => 'bearerToken',
            ]
        ]);
    }

    public function deleteUser(Request $request)
    {
        $user = User::where('email', $request->email);
        $user->delete();

        return response()->json(['user' => $user], Response::HTTP_NO_CONTENT);
    }
}
