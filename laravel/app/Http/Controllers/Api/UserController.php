<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user() {
        return new UserResource(auth()->user());
    }

    public function index() {
        return UserResource::collection(User::all());
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'is_privacy' => '',
            'firstname' => '',
            'lastname' => '',
            'username' => '',
            'email' => '',
            'password' => '',
        ]);

        if ($validated['password']) {
            auth()->user()->password = Hash::make($validated['password']);
        }
        auth()->user()->update($validated);
        return new UserResource(auth()->user());
    }
}
