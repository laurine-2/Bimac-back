<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Choice;
use App\Models\UserAnswer;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class QuizController extends Controller
{
    //list des category
    public function index()
    {
        return Quiz::all();
    }
    //creation d'un nouveau quiz
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            // 'category_id' => 'required|exists:categories,id',
            // 'manager_id' => 'required|exists:users,id',
        ]);
        $quiz = Quiz::create($request->all());
        return response()->json($quiz, 201);
    }
    //affichage d'un quiz spécifique
    // public function show(Quiz $quiz)
    // {
    //     return $quiz;
    // }
    public function show($id)
{
    // Utilisez le chargement en eager loading pour récupérer les questions et les choix associés
    $quiz = Quiz::with('questions.choices')->findOrFail($id);
    return response()->json($quiz);
}


    // Récupérer les quiz par catégorie
    public function getQuizzesByCategory($categoryId)
    {
        // Récupérer les quiz correspondant à la catégorie donnée
        $quizzes = Quiz::where('category_id', $categoryId)->get();

        // Retourner les quiz en format JSON
        return response()->json($quizzes);
    }
    
    //modification d'un quiz
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'manager_id' => 'required|exists:users,id',
        ]);
        $quiz->update($request->all());
        return response()->json($quiz, 200);
    }
    //suppression d'un quiz
    public function destroy(Quiz $quiz){
        $quiz->delete();
        return response()->json(null, 204);
    }
// Methode permettant de recuperer les question par quizz
public function getQuestions($quizId)
{
    // Charger le quiz avec ses questions et les choix associés
    $quiz = Quiz::with('questions.choices')->find($quizId);

    if (!$quiz) {
        return response()->json(['error' => 'Quiz not found'], 404);
    }

    // Retourner les questions si elles existent
    if ($quiz->questions->isEmpty()) {
        return response()->json([], 200); // Retourne un tableau vide si pas de questions
    }

    return response()->json($quiz->questions, 200);
}

    //soumettre les reponses du quiz et calculer le score.
    public function submitAnswer(Request $request, $quizId)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.choice_ids' => 'required|array',
            'answers.*.choice_ids.*' => 'required|exists:choices,id',
        ]);

        $user = Auth::user();
        $quiz = Quiz::findOrFail($quizId);
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;

        foreach ($request->answers as $answer) {
            $questionId = $answer['question_id'];
            $selectedChoices = $answer['choice_ids'];

            // Récupérer toutes les réponses correctes pour la question
            $correctChoices = Choice::where('question_id', $questionId)
                ->where('is_correct', true)
                ->pluck('id')
                ->toArray();

            // Comparer les choix de l'utilisateur avec les choix corrects
            if (array_diff($correctChoices, $selectedChoices) === [] &&
                array_diff($selectedChoices, $correctChoices) === []) {
                $correctAnswers++;
            }

            // Enregistrer chaque choix sélectionné par l'utilisateur dans la table user_answers
            foreach ($selectedChoices as $choiceId) {
                UserAnswer::create([
                    'user_id' => $user->id,
                    'question_id' => $questionId,
                    'choice_id' => $choiceId,
                ]);
            }
        }

        // Calculer le score en pourcentage
        $score = ($correctAnswers / $totalQuestions) * 100;

        // Enregistrer le résultat dans la table results
        $result = Result::create([
            'score' => $score,
            'user_id' => $user->id,
            'quiz_id' => $quizId,
        ]);

        return response()->json(['message' => 'Quiz submitted successfully', 'result' => $result]);
    }

    }

