<?php

namespace App\Http\Controllers\Api\Livreur;

use App\Enum\UserStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LivreurResource;
use App\Models\Livreur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthLivreurController extends Controller
{
    public function login(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
        $user = User::where('email', $validated["email"])->first();
        if ($user && Hash::check($validated['password'], $user->password) && $user->status == UserStatus::ACTIVE) {
            $livreur = Livreur::where('user_id', $user->id)->first();
            if ($livreur) {
                return ApiResponse::success(data: new LivreurResource($user), message: 'Login successful', code: 201);
            }
        }
        return ApiResponse::error(message: 'Email or password is incorrect', code: 400);
    }
}
