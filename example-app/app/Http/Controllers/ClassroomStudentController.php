<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassroomStudent;

class ClassroomStudentController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        return response()->json(ClassroomStudent::all(), 200);
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'student_id' => 'required|exists:students,id',
        ]);

        $classroomStudent = ClassroomStudent::create($validatedData);
        return response()->json($classroomStudent, 201);
    }

    // Display the specified resource
    public function show($id)
    {
        $classroomStudent = ClassroomStudent::find($id);
        if (!$classroomStudent) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($classroomStudent, 200);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $classroomStudent = ClassroomStudent::find($id);
        if (!$classroomStudent) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $validatedData = $request->validate([
            'classroom_id' => 'sometimes|exists:classrooms,id',
            'student_id' => 'sometimes|exists:students,id',
        ]);

        $classroomStudent->update($validatedData);
        return response()->json($classroomStudent, 200);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $classroomStudent = ClassroomStudent::find($id);
        if (!$classroomStudent) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        
        $classroomStudent->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
