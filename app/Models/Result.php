<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'score',
        'user_id',
        'quiz_id',
    ];

    //un résultat appartient à un user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //un résultat appartient à un quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
