<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        // Récupérer tous les utilisateurs
        $users = User::all();
        return response()->json($users);
    }
    // Inscription d'un nouvel utilisateur.
    public function register(Request $request)
    {
        
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'matricule' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            // 'role' => 'required|in:user,manager,admin',
            'team_id' => 'required|exists:teams,id', // Validation pour l'équipe sélectionnée
        ]);
        
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'matricule' => $request->matricule,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user', // Toujours définir le rôle comme 'user' par défaut
            'team_id' => $request->team_id, // Assigner l'équipe
        ]);
        
        return response()->json(['message' => 'User registered successfully'], 201);
    } 

    //connexion d'un utilisateur
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            // Include user details in the response
            return response()->json([
                'token' => $token,
                'user' => [
                    'id'=> $user->id,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'username' => $user->matricule, // Assuming matricule is used as username
                    'role' => $user->role
                ]
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    
    }
}
