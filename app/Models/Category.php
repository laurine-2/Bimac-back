<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'description',
        'manager_id',
        'team_id',
    ];
    public function quizzers(){
        return $this->hasMany(Quiz::class);
    }
    public function manager(){
        return $this->belongsTo(User::class,'manager_id');
    }
    public function team(){
        return $this->belongsTo(Team::class,'team_id');
        }
   
}
