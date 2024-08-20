<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'choice_id' => 'required|exists:choices,id',
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
            'choice_id' => 'required|exists:choices,id',
            
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

    public function submitQuiz(Request $request, $quizId)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.choice_id' => 'required|exists:choices,id',
        ]);

        $user = Auth::user();
        $correctAnswers = 0;
        $totalQuestions = count($request->answers);

        foreach ($request->answers as $answer) {
            $choice = Choice::find($answer['choice_id']);
            if ($choice && $choice->is_correct) {
                $correctAnswers++;
            }

            // Enregistrer la réponse de l'utilisateur
            UserAnswer::create([
                'user_id' => $user->id,
                'question_id' => $answer['question_id'],
                'choice_id' => $answer['choice_id'],
            ]);
        }

        // Calcul du score
        $score = ($correctAnswers / $totalQuestions) * 100;

        // Sauvegarder le résultat dans la table `results`
        Result::create([
            'user_id' => $user->id,
            'quiz_id' => $quizId,
            'score' => $score,
        ]);

        return response()->json(['message' => 'Quiz submitted successfully', 'score' => $score]);
    }
}
