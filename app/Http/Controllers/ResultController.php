<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

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
    public function index()
    {
        return Result::all();
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
