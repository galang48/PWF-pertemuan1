<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

#[Group('Auth', weight: 1)]
class AuthController extends Controller
{
    #[Endpoint(operationId: 'auth.getToken', title: 'auth.getToken')]
    public function getToken(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Input tidak valid',
                    'errors' => $validator->errors(),
                ], 400);
            }

            $data = $validator->validated();

            if (! Auth::attempt($data)) {
                Log::info('[Auth - API] Email atau password salah');

                return response()->json([
                    'message' => 'Email atau password salah',
                ], 401);
            }

            $user = User::where('email', $data['email'])->first();
            $token = $user->createToken('api_token')->plainTextToken;

            Log::info('[Auth - API] Token berhasil dibuat', [
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'Login berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat login API', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }
}
