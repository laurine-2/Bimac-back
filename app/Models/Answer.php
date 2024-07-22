<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'is_correct',
        'question_id',
    ];
    //une reponse appartient a une question
    public function question(){
        return $this->belongsTo(Question::class);
    }
    //relation avec les reponses des users
    public function userAnswer(){
        return $this->hasMany(UserAnswer::class);
    }
}
