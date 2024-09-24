<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController; // Menggunakan BaseController
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return $this->sendResponse($user, 'Registration successful.');
        } catch (\Exception $e) {
            return $this->sendError('Registration failed.', ['error' => $e->getMessage()], 500);
        }
    }
}
