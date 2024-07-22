<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use Illuminate\Http\Request;

class UserAnswerController extends Controller
{
    //afficher toutes les reponses des users
    public function index()
    {
        return UserAnswer::all();
    }
    //creer une nouvelle reponse d'un user
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
        ]);

        $userAnswer = UserAnswer::create($request->all());
        return response()->json($userAnswer, 201);
    }
    //afficher une reponse d'un user
    public function show(UserAnswer $userAnswer)
    {
        return $userAnswer;
    }
    //mettre a jour une reponse d'un user
    public function update(Request $request, UserAnswer $userAnswer)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
        ]);

        $userAnswer->update($request->all());
        return response()->json($userAnswer, 200);
    }
    //supprimer une reponse d'un user
    public function destroy(UserAnswer $userAnswer)
    {
        $userAnswer->delete();
        return response()->json(null, 204);
    }
}
