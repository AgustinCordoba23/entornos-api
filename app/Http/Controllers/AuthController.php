<?php

namespace App\Http\Controllers;

use App\Exceptions\UnprocessableEntityException;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Bad credentials'
            ], 401);
        }

        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken('bearer-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token
        ], 200);
    }

    public function register(RegisterRequest $request) {
        $fields = $request->only('email', 'password', 'name');

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('bearer-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token
        ], 201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([], 200);
    }

    public function changePassword(ChangePasswordRequest $request) {
        $newPassword = $request->new_password;
        $oldPassword = $request->old_password;

        /** @var User $currentUser */
        $currentUser = Auth::user();

        if (!Hash::check($oldPassword, $currentUser->password)) {
            return response()->json([
                'message' => 'Bad credentials'
            ], 401);
        }

        $currentUser->password = Hash::make($newPassword);
        $currentUser->save();

        return response(null, 200);
    }
}

