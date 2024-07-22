<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'description',
        'category_id',
        'manager_id',
    ];

    //relation entre quiz et category (un quiz appartient à une category)

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //relation entre quiz et user (manager) (un quiz est géré par un user
    public function manager(){
        return $this->belongsTo(User::class, 'manager_id');
    }

    //relation entre quiz et question (un quiz peut avoir plusieurs question)
    public function questions(){
        return $this->hasMany(Question::class);
    }

    //relation entre quiz et resultat (un quiz peut avoir  plusieurs resultats)
    public function results(){
        return $this->hasMany(Result::class);

    }
    
}
