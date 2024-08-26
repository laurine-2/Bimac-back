<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return Team::all();
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'manager_id' => 'required|exists:users,id',
    ]);

    $team = Team::create($validatedData);

    return response()->json($team, 201); // Renvoie la réponse JSON avec le statut 201 Created
}

    
    public function show($id)
    {
        $team = Team::with('manager', 'members')->findOrFail($id);
        return response()->json($team);
    }

    public function update(Request $request, Team $team)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'required|exists:users,id',
        ]);

        $team->update($validatedData);
        return response()->json($team);
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return response()->json(null, 204);
    }
}
