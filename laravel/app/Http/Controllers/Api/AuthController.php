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
                'message' => [
                    'type' => 'error',
                    'data' => 'Ievadītie dati nav korekti.',
                ]
            ]);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;
        return response(['user' => auth()->user(), 'token' => $token]);
    }
}
