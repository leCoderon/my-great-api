<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Inscription
     */
    public function register(UserRegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return response()->json([
                'status' => 200,
                'message' => 'Le user a été crée avec success',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Connexion
     * 
     */
    public function login(LoginUserRequest $request)
    {

        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {

            $user = auth()->user();

            //Génère une clé d'authentification pour l'utlisateur
            $token = $user->createToken('Mrok86uYK50h3DhaGuP0fmldt238dtdqg1WuPCRu9e0edffa')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Utilisateur connecté',
                'token' => $token,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'message' => 'Aucun utilisateur trouvé',
                'status' => 403,

            ]);
        }
    }
}
