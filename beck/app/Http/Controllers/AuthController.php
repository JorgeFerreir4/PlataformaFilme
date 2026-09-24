<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request){
        
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email) ->first();

        if ($user != null){
            if (Hash::check($password, $user->password)){
                $token = JWTAuth::fromUser($user);
                return response()->json($token);
            }
            else{
                return response()->json(['error' => 'Senha invalida'], 401);
            }
        }
        else{
            return response()->json(['error' => 'Usuário não encontrado'], 404);r
        }

        

    }
}
