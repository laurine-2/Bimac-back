<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //list de category
    public function index()
    {
        return Category::all();
    

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
        \Log::info($request->all());
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            // 'manager_id' => ['required', 'exists:users,id']
        ]);

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
