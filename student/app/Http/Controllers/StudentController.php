<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Http; // Utilisation de HTTP client Laravel
use GuzzleHttp\Client;


class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        // Validation de base
        $request->validate([
            'name' => 'required|string|max:255',
            'genre' => 'required|string',
            'school_id' => 'required|integer', 
        ]);

        $client = new Client();
        $response = $client->get("http://127.0.0.1:8000/api/schools/{$request->school_id}");

        if ($response->getStatusCode() != 200) {
            return response()->json(['error' => 'The selected school id is invalid.'], 400);
        }

        $student = Student::create($request->all());
        return response()->json($student, 201);
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
