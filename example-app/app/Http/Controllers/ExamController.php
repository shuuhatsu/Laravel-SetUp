<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use Illuminate\Validation\ValidationException;

class ExamController extends Controller
{
    public function index()
    {
        return response()->json(Exam::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'date' => 'required|date',
                'course_id' => 'required|exists:courses,id',
            ]);

            $exam = Exam::create($validatedData);
            return response()->json($exam, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return response()->json(['message' => 'Exam not found'], 404);
        }
        return response()->json($exam, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $exam = Exam::find($id);
            if (!$exam) {
                return response()->json(['message' => 'Exam not found'], 404);
            }

            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'date' => 'sometimes|required|date',
                'course_id' => 'sometimes|required|exists:courses,id',
            ]);

            $exam->update($validatedData);
            return response()->json($exam, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return response()->json(['message' => 'Exam not found'], 404);
        }
        $exam->delete();
        return response()->json(['message' => 'Exam deleted successfully'], 200);
    }
}
