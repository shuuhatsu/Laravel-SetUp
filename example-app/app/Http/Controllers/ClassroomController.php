<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use Illuminate\Validation\ValidationException;

class ClassroomController extends Controller
{
    public function index()
    {
        return response()->json(Classroom::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'year' => 'required|integer',
                'grade_id' => 'required|exists:grades,id',
                'section' => 'required|string|max:2',
                'status' => 'boolean',
                'remarks' => 'nullable|string|max:45',
                'teacher_id' => 'required|exists:teachers,id',
            ]);

            $classroom = Classroom::create($validatedData);

            return response()->json($classroom, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $classroom = Classroom::find($id);

        if (!$classroom) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        return response()->json($classroom, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $classroom = Classroom::find($id);

            if (!$classroom) {
                return response()->json(['message' => 'Classroom not found'], 404);
            }

            $validatedData = $request->validate([
                'year' => 'integer',
                'grade_id' => 'exists:grades,id',
                'section' => 'string|max:2',
                'status' => 'boolean',
                'remarks' => 'nullable|string|max:45',
                'teacher_id' => 'exists:teachers,id',
            ]);

            $classroom->update($validatedData);

            return response()->json($classroom, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $classroom = Classroom::find($id);

        if (!$classroom) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        $classroom->delete();

        return response()->json(['message' => 'Classroom deleted successfully'], 200);
    }
}
