<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use mysql_xdevapi\Exception;

class AuthController extends Controller
{
    public function register(UserRequest $request) {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        return new UserResource($user);
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'username' => 'sometimes',
            'email' => 'email|sometimes',
            'password' => 'required',
        ]);

        if (!auth()->attempt($validated)) {
            return response()->json([
                'errors' => [
                    'data' => 'Entered data are incorrect.',
                ]
            ], 400);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;
        return response(['user' => auth()->user(), 'token' => $token]);
    }

    public function logout() {
        $user = auth()->user();
        auth()->user()->token()->revoke();
        return response()->json([
            'message' => [
                'type' => 'success',
                'data' => 'Successfully logged out',
            ],
            'user' => $user,
        ], 200);
    }
}
