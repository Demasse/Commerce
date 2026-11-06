<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index()
    {
        $students = Student::latest()->get();
        return response()->json($students);
    }

    // Enregistrer un nouvel étudiant
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'filiere' => 'required|string|max:255',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Étudiant ajouté avec succès !',
            'student' => $student
        ]);
    }

    // Supprimer un étudiant
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'message' => 'Étudiant supprimé avec succès !'
        ]);
    }
}
