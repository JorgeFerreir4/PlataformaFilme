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
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        

    }

    public function cadastro(Request $request){

        $email = $request->input('email');
        $password = $request->input('password');
        $name = $request->input('name');
        
        
        $validate = $request->validate([
            'email' => ['required','email:rfc,dns'],
            'password' => ['required','min:8'],
            'name' => ['required','min:3']
        ]);

        $verificaremail = User::where('email', $email)->exists();
        if($verificaremail == True){
            return response()->json(['erro'=>'Usuaŕio já cadastrado'], 400);
        }

        $validate['password'] = Hash::make($validate['password']);
        $user = User::create($validate);
        return response()->json(['message' => 'Usuário cadastrado com sucesso.'], 201);
    }
}
