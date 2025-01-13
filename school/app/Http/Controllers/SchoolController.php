<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    // Récupérer toutes les écoles
    public function index()
    {
        $schools = School::all();
        return response()->json($schools);
    }

    // Créer une nouvelle école
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'director_name' => 'required|string|max:255',
        ]);

        // Créer une nouvelle école avec les données validées
        $school = School::create($request->all());
        return response()->json($school, 201);
    }

    // Afficher une école spécifique par ID
    public function show($id)
    {
        $school = School::findOrFail($id);
        return response()->json($school);
    }

    // Mettre à jour une école
    public function update(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'director_name' => 'nullable|string|max:255',
        ]);

        $school->update($request->all());
        return response()->json($school);
    }

    // Supprimer une école
    public function destroy($id)
    {
        $school = School::findOrFail($id);
        $school->delete();
        return response()->json(null, 204);
    }
}
