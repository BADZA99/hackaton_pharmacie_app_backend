<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use PhpParser\Node\Stmt\Return_;

class Authcontroller extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users',
            'mot_de_passe' => 'required|string|min:6|confirmed',
        ]);

    
        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role_id' => 2, // Default role (e.g., client)
        ]);

        // $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            // 'token' => $token,
        ], 201);
    }

    /**
     * Login a user.
     */
    public function login(Request $request)
    {
        // Valider les données d'entrée
        $request->validate([
            'email' => 'required|string|email',
            'mot_de_passe' => 'required|string',
        ]);

        // Tenter de connecter l'utilisateur
        if (Auth::attempt(['email' => $request->email, 'password' => $request->mot_de_passe])) {
            // Récupérer l'utilisateur authentifié
            $user = Auth::user();

            // Générer un token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Créer un cookie pour le token
            $cookie = cookie('jwt', $token, 60 * 24); // 1 jour

            return response()->json([
                'message' => 'User logged in successfully',
                'user' => $user,
                'jwt' => $token,
            ], 200)->withCookie($cookie);
        }

        // Si les informations d'identification sont incorrectes
        return response()->json([
            'message' => 'Invalid credentials',
        ], Response::HTTP_UNAUTHORIZED);
    }


    // logged user
    /**
     * Get the authenticated user.
     */
    public function getLoggedUser(Request $request)
    {
        $user = $request->user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
    
        return response()->json(['user' => $user], 200);
    }

    /**
     * Logout the authenticated user.
     */
    public function logout()
    {
        $cookie = Cookie::forget('jwt');
        return \response([
            'message' => 'logout success            git checkout -b main'
        ])->withCookie($cookie);
    }


}