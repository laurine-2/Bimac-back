<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'quiz_id',
    ];
    // une question appartient à un quiz
    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
    // une question a plusieurs reponses
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
    // une question peut avoir plusieurs reponses
    public function answers(){
        return $this->hasMany(Answer::class);
    }

    //relation avec les reponce des users
    public function userAnswers(){
        return $this->hasMany(UserAnswer::class);
    }
}
