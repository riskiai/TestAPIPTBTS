<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController; // Menggunakan BaseController
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends BaseController
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->only('username', 'password'))) {
            $token = $request->user()->createToken('API Token')->plainTextToken;

            return $this->sendResponse(['token' => $token], 'Login successful.');
        }

        return $this->sendError('Invalid credentials.', ['error' => 'Unauthorized'], 401);
    }
}
