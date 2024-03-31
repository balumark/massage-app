<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Facades\JsonResponser;

class UserAuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken($user->name . '-AuthToken')->accessToken;
            if (!$user) {
                throw new Exception('Usert creation failed, please contact us.', 500);
            }

            DB::commit();
        } catch (Exception $exception) {
            return JsonResponser::fail('User creation failed.', null, $exception);
        }

        return JsonResponser::success('User created!', [
            'access_token' => $this->tokenBeauty($token),
        ]);
    }

    public function login(UserLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return JsonResponser::responseWithHttpCode('Invalid credentials.', null, 401);
        }
        $user->tokens()->delete();
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return JsonResponser::success('Welcome!', [
            'access_token' => $this->tokenBeauty($token),

        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return JsonResponser::success('Logged out!');
    }

    private function tokenBeauty($token){
        $token = explode('|',$token);
        return $token[1];
    }
}
