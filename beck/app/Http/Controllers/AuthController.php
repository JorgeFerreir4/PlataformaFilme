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
        $senha = $request->input('senha');
        $user = User::where('email', $email) ->first();

        if ($user != null){
            if (Hash::check($senha, $user->senha)){
                $token = JWTAuth::fromUser($user);
                return response()
                        ->json([
                            'message' => 'Login realizado com sucesso.'
                        ])
                        ->cookie(
                            'token',
                            $token,
                            60,
                            '/',
                            null,
                            false,
                            true,
                            false,
                            'lax'
                        );
            }
            else{
                return response()->json(['error' => 'Senha invalida'], 401);
            }
        }
        else{
            return response()->json(['error' => 'Email não cadastrado'], 404);
        }

        

    }

    public function cadastro(Request $request){

        $email = $request->input('email');
        $senha = $request->input('senha');
        $nome = $request->input('nome');
        
        
        $validate = $request->validate([
                    'email' => ['required', 'email'],
                    'senha' => ['required', 'min:8'],
                    'nome' => ['required', 'min:3'],
                ], [
                    'email.required' => 'O e-mail é obrigatório.',
                    'email.email' => 'O e-mail informado não é válido.',
                    'senha.required' => 'A senha é obrigatória.',
                    'senha.min' => 'A senha deve ter pelo menos 8 caracteres.',
                    'nome.required' => 'O nome é obrigatório.',
                    'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
                ]);

        $verificaremail = User::where('email', $email)->exists();
        if($verificaremail == True){
            return response()->json(['erro'=>'Usuaŕio já cadastrado'], 400);
        }

        $validate['senha'] = Hash::make($validate['senha']);
        $user = User::create($validate);
        return response()->json(['message' => 'Usuário cadastrado com sucesso.'], 201);
    }
}
