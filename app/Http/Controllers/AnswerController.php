<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    //liste des reponses
    public function index()
    {
        return Answer::all();
    }
    //creation d'une reponse
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'is_correct' => 'required|boolean',
            'question_id' => 'required|exists:questions,id',
        ]);
        $answer = Answer::create($request->all());
        return response()->json($answer, 201);
    }
    //affichage d'une reponse
    public function show(Answer $answer)
    {
        return $answer;
    }
    //modification d'une reponse
    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'content' => 'required|string',
            'is_correct' => 'required|boolean',
            'question_id' => 'required|exists:questions,id',
        ]);
        $answer->update($request->all());
        return response()->json($answer, 200);
    }
    //suppression d'une reponse
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return response()->json(null, 204);
    }
}
