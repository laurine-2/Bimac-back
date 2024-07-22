<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    //list des resultat
    public function index()
    {
        return Result::all();
    }
    //afficher un resultat
    public function show(Result $result)
    {
        return $result;
    }
    //supprimer un resultat
    public function destroy(Result $result)
    {
        $result->delete();
        return response()->json(null, 204);
    }
}
