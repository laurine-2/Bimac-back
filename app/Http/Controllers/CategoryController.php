<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    //list de category
    public function index(Request $request)
    {
        $user = auth::user();
        // Récupérer les catégories visibles pour l'équipe de l'utilisateur
    if ($user->role === 'manager') {
        $categories = Category::where('manager_id', $user->id)->get();
    } else {
        // Récupérer les catégories de l'équipe de l'utilisateur
        $categories = Category::where('team_id', $user->team_id)->get();
    }

    return response()->json($categories);
    }

    //creation d'une nouvelle category
    public function store(Request $request)
    {
    //    return 'test';
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'manager_id' => 'require|exists:users,id',

        // ]);
        
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            // 'manager_id' => ['required', 'exists:users,id'],
            'team_id' => ['required', 'exists:teams,id']
        ]);

         // Ajouter l'ID du manager connecté à la catégorie
         $data['manager_id'] = $request->user()->id;
        $category = Category::create($data);
        return response()->json($category, 201);
    }

    // Afficher une category spécifique
    public function show(Category $category)
    {
        return $category;
    }

    // public function show($id)
    // {
    //     $category = Category::find($id);
    
    //     if ($category) {
    //         return response()->json($category, 200);
    //     } else {
    //         return response()->json(['message' => 'Category not found'], 404);
    //     }
    // }
    

    //mise ajour des category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            // 'manager_id' => 'require|exists:users,id',
        ]);
        $category->update($request->all());
        return response()->json($category, 200);
    }
    //suppression d'une category
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }

}
