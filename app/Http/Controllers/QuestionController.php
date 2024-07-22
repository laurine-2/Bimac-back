<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //list des questions
    public function index()
    {
        return Question::all();
    }
    //creation d'une nouvelle question
    public function store(Request $request)
    {
        $request->validate([
        'content' => 'required|string',
        'quiz_id' => 'required|exists:quizzes,id',
        ]);
        $question = Question::create($request->all());
        return response()->json($question, 201);
    }
    //affichage d'une question
    public function show(Question $question)
    {
        return $question;
    }
    //modification d'une question
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
        ]);
        $question->update($request->all());
        return response()->json($question, 200);
    }
    //suppression d'une question
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(null, 204);
    }
}
