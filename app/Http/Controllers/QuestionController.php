<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Choice;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function index()
    {
        // Récupérer toutes les questions
        return Question::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
            'choices' => 'required|array',
            'choices.*.content' => 'required|string',
            'choices.*.is_correct' => 'required|boolean',
        ]);

        // Créer la question
        $question = Question::create([
            'content' => $validatedData['content'],
            'quiz_id' => $validatedData['quiz_id'],
        ]);

        // Créer les choix associés
        foreach ($validatedData['choices'] as $choiceData) {
            Choice::create([
                'content' => $choiceData['content'],
                'is_correct' => $choiceData['is_correct'],
                'question_id' => $question->id,
            ]);
        }

        return response()->json($question->load('choices'), 201);
    }

    // public function show($id)
    // {
    //     // Récupérer une question spécifique par ID
    //     return Question::find($id);
    // }

    public function show($id)
{
    $quiz = Quiz::with('questions.choices')->findOrFail($id);
    return response()->json($quiz);
}


    public function getQuestionsByQuiz($quizId)
    {
        // Récupérer les questions d'un quiz spécifique
        return Question::where('quiz_id', $quizId)->with('choices')->get();
    }

    public function update(Request $request, Question $question)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
            'choices' => 'required|array',
            'choices.*.content' => 'required|string',
            'choices.*.is_correct' => 'required|boolean',
        ]);

        // Mettre à jour la question
        $question->update([
            'content' => $validatedData['content'],
            'quiz_id' => $validatedData['quiz_id'],
        ]);

        // Supprimer les anciens choix
        $question->choices()->delete();

        // Créer les nouveaux choix
        foreach ($validatedData['choices'] as $choiceData) {
            Choice::create([
                'content' => $choiceData['content'],
                'is_correct' => $choiceData['is_correct'],
                'question_id' => $question->id,
            ]);
        }

        return response()->json($question->load('choices'), 200);
    }
}
