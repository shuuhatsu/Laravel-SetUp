<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentModel;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    // Get all students
    public function index()
    {
        return response()->json(StudentModel::all(), 200);
    }

    // Store a new student
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:students,email',
                'password' => 'required|min:6',
                'fname' => 'required|string|max:45',
                'lname' => 'required|string|max:45',
                'dob' => 'required|date',
                'phone' => 'nullable|string|max:15',
                'mobile' => 'nullable|string|max:15',
                'parent_id' => 'nullable|exists:parents,id',
                'date_of_join' => 'nullable|date',
                'status' => 'boolean',
            ]);

            $student = StudentModel::create($validated);
            return response()->json($student, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Show a specific student
    public function show($id)
    {
        $student = StudentModel::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        return response()->json($student, 200);
    }

    // Update a student
    public function update(Request $request, $id)
    {
        try {
            $student = StudentModel::find($id);
            if (!$student) {
                return response()->json(['message' => 'Student not found'], 404);
            }

            $validated = $request->validate([
                'email' => 'email|unique:students,email,' . $id,
                'password' => 'sometimes|min:6',
                'fname' => 'sometimes|string|max:45',
                'lname' => 'sometimes|string|max:45',
                'dob' => 'sometimes|date',
                'phone' => 'nullable|string|max:15',
                'mobile' => 'nullable|string|max:15',
                'parent_id' => 'nullable|exists:parents,id',
                'date_of_join' => 'nullable|date',
                'status' => 'boolean',
            ]);

            $student->update($validated);
            return response()->json($student, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Delete a student
    public function destroy($id)
    {
        $student = StudentModel::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        $student->delete();
        return response()->json(['message' => 'Student deleted'], 200);
    }
}
