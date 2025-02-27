<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherModel;
use Illuminate\Validation\ValidationException;

class TeacherController extends Controller
{
    // Get all teachers
    public function index()
    {
        return response()->json(TeacherModel::all(), 200);
    }

    // Store a new teacher
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:teachers,email',
                'password' => 'required|min:6',
                'fname' => 'required|string|max:45',
                'lname' => 'required|string|max:45',
                'dob' => 'required|date',
                'phone' => 'nullable|string|max:15',
                'mobile' => 'nullable|string|max:15',
                'date_of_join' => 'nullable|date',
                'status' => 'boolean',
            ]);

            $teacher = TeacherModel::create($validated);
            return response()->json($teacher, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Show a specific teacher
    public function show($id)
    {
        $teacher = TeacherModel::find($id);
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }
        return response()->json($teacher, 200);
    }

    // Update a teacher
    public function update(Request $request, $id)
    {
        try {
            $teacher = TeacherModel::find($id);
            if (!$teacher) {
                return response()->json(['message' => 'Teacher not found'], 404);
            }

            $validated = $request->validate([
                'email' => 'email|unique:teachers,email,' . $id,
                'password' => 'sometimes|min:6',
                'fname' => 'sometimes|string|max:45',
                'lname' => 'sometimes|string|max:45',
                'dob' => 'sometimes|date',
                'phone' => 'nullable|string|max:15',
                'mobile' => 'nullable|string|max:15',
                'date_of_join' => 'nullable|date',
                'status' => 'boolean',
            ]);

            $teacher->update($validated);
            return response()->json($teacher, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Delete a teacher
    public function destroy($id)
    {
        $teacher = TeacherModel::find($id);
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }
        $teacher->delete();
        return response()->json(['message' => 'Teacher deleted'], 200);
    }
}
