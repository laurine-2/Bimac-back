<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'manager_id'];

    // Relation avec le manager (User)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Relation avec les membres de l'équipe (Users)
    public function members()
    {
        return $this->hasMany(User::class);
    }

    // Relation avec les catégories
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    // Relation avec les quiz
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}