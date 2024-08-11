<?php

use App\Http\Controllers\ChoicesController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\http\Request;
// use Illuminate\http\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UserAnswerController;

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


// Routes protégées par l'authentification
Route::middleware('auth:sanctum')->group(function () {

     // Routes CRUD pour les réponses des utilisateurs

     Route::get('user-answers', [UserAnswerController::class, 'index']);
     Route::post('user-answers', [UserAnswerController::class, 'store']);
     Route::get('user-answers/{id}', [UserAnswerController::class, 'show']);
     Route::put('user-answers/{id}', [UserAnswerController::class, 'update']);
     Route::delete('user-answers/{id}', [UserAnswerController::class, 'destroy']);
 
     // Routes CRUD pour les catégories
     Route::get('categories', [CategoryController::class, 'index']);
     Route::post('categories', [CategoryController::class, 'store']);
     Route::get('categories/{id}', [CategoryController::class, 'show']);
     Route::put('categories/{id}', [CategoryController::class, 'update']);
     Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
 
     // Routes CRUD pour les quiz
     Route::get('quizzes', [QuizController::class, 'index']);
     Route::post('quizzes', [QuizController::class, 'store']);
     Route::get('quizzes/{id}', [QuizController::class, 'show']);
     Route::put('quizzes/{id}', [QuizController::class, 'update']);
     Route::delete('quizzes/{id}', [QuizController::class, 'destroy']);
 
     // Routes CRUD pour les questions
     Route::get('questions', [QuestionController::class, 'index']);
     Route::post('questions', [QuestionController::class, 'store']);
     Route::get('questions/{id}', [QuestionController::class, 'show']);
     Route::put('questions/{id}', [QuestionController::class, 'update']);
     Route::delete('questions/{id}', [QuestionController::class, 'destroy']);
 
     //Routes CRUD pour les choix
     Route::get('choices', [ChoicesController::class, 'index']);
     Route::post('choices', [ChoicesController::class, 'store']);
     Route::get('choices/{id}', [ChoicesController::class, 'show']);
     Route::put('choices/{id}', [ChoicesController::class, 'update']);
     Route::delete('choices/{id}', [ChoicesController::class, 'destroy']);

     // Routes CRUD pour les réponses
     Route::get('answers', [AnswerController::class, 'index']);
     Route::post('answers', [AnswerController::class, 'store']);
     Route::get('answers/{id}', [AnswerController::class, 'show']);
     Route::put('answers/{id}', [AnswerController::class, 'update']);
     Route::delete('answers/{id}', [AnswerController::class, 'destroy']);
 
     // Routes CRUD pour les résultats
     Route::get('results', [ResultController::class, 'index']);
     Route::get('results/{id}', [ResultController::class, 'show']);
     Route::delete('results/{id}', [ResultController::class, 'destroy']);
 
     // Soumettre les réponses d'un quiz
     Route::post('quizzes/{quizId}/submit', [QuizController::class, 'submitAnswers']);
     Route::get('categories/{categoryId}/quizzes', [QuizController::class, 'getQuizzesByCategory']);
     Route::get('/quizzes/{quizId}/questions', [QuestionController::class, 'getQuestionsByQuiz']);

});
