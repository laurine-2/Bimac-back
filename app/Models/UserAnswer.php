<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'question_id',
        'choice_id', // Réponse sélectionnée par l'utilisateur
    ];

    //relation avec les users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relation avec les questions
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relation avec le choix (choice)
    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
    
}
