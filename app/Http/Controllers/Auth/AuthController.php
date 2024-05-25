<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
   public function verifie()
    {
        $user = Auth::user() ?? auth()->user();
        $userModel = User::find(isset($user) ? $user->id : 0);
        $userModel->sendEmailVerificationNotification();
        return $this->successResponse("ok");
    }

   public function login(LoginRequest $request)
   {
       $credentials = $request->getCredentials();
        try {
            if (Auth::attempt($credentials)) {
                $token = Auth()->user()->createToken('Token')->accessToken;
                $expireIn = 24*60*60;
                return response([
                    'user' => Auth()->user()->name,
                    'email' => Auth()->user()->email,
                    'access_token' => $token,
                    'expiresIn' => $expireIn
                ], Response::HTTP_OK);
            }

            return response()->json(['message' => 'Usuario y/o contraseña incorrectos'], Response::HTTP_UNAUTHORIZED);

        } catch (\Exception $e) {
            $success = false;
            return response()->json(['Error' => $e->getMessage(), 'success' => $success]);
        }
   }

   public function logout()
   {
        Auth()->user()->tokens()->delete();
        return [
            'message' => 'Ha cerrado sesión correctamente'
        ];
   }
}
