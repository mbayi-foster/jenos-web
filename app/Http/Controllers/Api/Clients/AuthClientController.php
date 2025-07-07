<?php

namespace App\Http\Controllers\Api\Clients;

use App\Enum\UserStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Mail\CheckMail;
use App\Mail\MobileMail;
use App\Models\Code;
use App\Models\Profil;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthClientController extends Controller
{
    public function registreEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);
        $code = rand(100000, 999999);
        Code::create(['code' => $code, 'email' => $validated['email']]);
        $data = ['nom' => $validated['prenom'] . ' ' . $validated['nom'], 'code' => $code, "sujet" => "Confirmer l'adresse email"];
        // Mail::to($request->email)->send(new MobileMail($data));

        return ApiResponse::success(code: 201, data: ['code' => $code]);
    }

    public function storeClient(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|unique:users|max:255',
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required|regex:/^\+[0-9]{12}$/',
            'password' => 'required|min:6',
            'code' => 'required|numeric'
        ]);
        $code = Code::where('code', $validated['code'])
            ->where('email', $validated['email'])
            ->where('status', false)
            ->first();
        if (!$code) {
            return ApiResponse::error(code: 400);
        }
        if ($code->created_at->diffInMinutes(Carbon::now()) < 10) {
            $code->status = true;
            $code->save();
            $user = User::create([
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            if ($user) {
                Profil::create([
                    'nom' => $validated['nom'],
                    'prenom' => $validated['prenom'],
                    'phone' => $validated['phone'],
                    'user_id' => $user->id
                ]);
                return ApiResponse::success(data: new ClientResource($user), code: 201);
            }
            return ApiResponse::error(code: 400);
        }
        return ApiResponse::error(code: 400);
    }

    public function getUser(string $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return ApiResponse::error(code: 404);
        }
        return ApiResponse::success(data: new ClientResource($user));
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|exists:users|max:255',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $validated['email'])->where('status', UserStatus::ACTIVE)->first();

        if (!$user) {
            return ApiResponse::error(code: 400);
        }
        if (Hash::check($validated['password'], $user->password)) {
            return ApiResponse::success(data: new ClientResource($user), code: 201);
        }
        return ApiResponse::error(code: 400);
    }

    public function verifyEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|exists:users|max:255',
        ]);

        $user = User::where('email', $validated['email'])
            ->where('status', UserStatus::ACTIVE)
            ->first();
        if (!$user) {
            return ApiResponse::error();
        }

        $code = rand(100000, 999999);
        Code::create(['code' => $code, 'email' => $user->email]);
        $data = ['nom' => $user->profile->prenom . ' ' . $user->profile->nom, 'code' => $code, "sujet" => "Vérifier l'adresse email"];
        // Mail::to($request->email)->send(new CheckMail($data));
        return ApiResponse::success(data: ['code' => $code], code: 201);
    }

    public function changeForgetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required|min:6',
            'code' => 'required|numeric'
        ]);

        $code = Code::where('code', $validated['code'])
            ->where('email', $validated['email'])
            ->where('status', false)
            ->first();
        if (!$code) {
            return ApiResponse::error(code: 400);
        }
        if ($code->created_at->diffInMinutes(Carbon::now()) < 10) {
            $code->status = true;
            $code->save();

            $user = User::where('email', $validated['email'])->where('status', 'active')->first();
            if (!$user) {
                return ApiResponse::error();
            }

            $user->password = bcrypt($validated['password']);
            $user->save();

            return ApiResponse::success(data: new ClientResource($user), code: 201);
        }
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required|min:6',
            'lastPassword' => 'required|min:6',
        ]);

        $user = User::where('email', $validated['email'])->where('status', 'active')->first();
        if (!$user) {
            return ApiResponse::error();
        }

        if (Hash::check($validated['lastPassword'], $user->password)) {
            $user->password = bcrypt($validated['password']);
            $user->save();

            return ApiResponse::success(data: new ClientResource($user), code: 201);
        }

        return ApiResponse::error();
    }
}
