<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ResultController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'score' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'quiz_id' => 'required|exists:quizzes,id',
        ]);

        $result = Result::create($validatedData);
        return response()->json($result, 201);
    }
    //list des resultat
    public function index(Request $request)
{
    $user = $request->user(); // Récupérer l'utilisateur connecté
    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    // Récupérer les résultats avec les quiz associés
    $results = Result::with('quiz')->where('user_id', $user->id)->get();

    // Debug: vérifier si des résultats ont été trouvés
    if ($results->isEmpty()) {
        return response()->json(['message' => 'No results found'], 200); // Renvoyer un message explicite
    }

    return response()->json($results, 200); // Renvoyer les résultats trouvés
}

    

    //afficher un resultat
    public function show(Result $result)
    {
        return $result;
    }
    //supprimer un resultat
    public function destroy(Result $result)
    {
        $result->delete();
        return response()->json(null, 204);
    }
}
