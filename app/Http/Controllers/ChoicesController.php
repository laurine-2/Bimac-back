<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use Illuminate\Http\Request;

class ChoicesController extends Controller
{
    //
    public function index(){
        return Choice::all();
    }
    //create les choix
    public function store(Request $request){
        $request->validate([
            'content' => 'required|string|',
            'is_correct' => 'required|boolean',
            'question_id' => 'required|integer|'
            ]);
    }
    // chow choices
    public function show($id){
        return Choice::find($id);
        }

    
    //update les choix
    public function update(Request $request, $id){
        $request->validate([
            'content' => 'required|string|',
            'question_id' => 'required|integer|'
            ]);
            }
            //delete les choix
    public function destroy($id){
        Choice::destroy($id);
    }
}
