<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\UTCDateTime;  // Ajoutez cette ligne
use MongoDB\Client as MongoClient;  // Ajoutez cette ligne
use Carbon\Carbon;



class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        Log::info('Début de la requête store');

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'genre' => 'required|string',
                'school_id' => 'required|integer',
            ]);

            Log::info('Test de création student...');

            $student = Student::create([
                'name' => $request->name,
                'genre' => $request->genre,
                'school_id' => $request->school_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            Log::info('Student créé avec succès', ['student' => $student]);

            return response()->json($student, 201);
        } catch (\Exception $e) {
            Log::error('Erreur:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'error' => 'Erreur lors de la création',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'genre' => 'nullable|string',
            'school_id' => 'nullable|exists:schools,id',
        ]);

        $student->update($request->all());
        return response()->json($student);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(null, 204);
    }
}
