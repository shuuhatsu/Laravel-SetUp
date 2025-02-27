<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamResult;
use Illuminate\Validation\ValidationException;

class ExamResultController extends Controller
{
    public function index()
    {
        return response()->json(ExamResult::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'student_id' => 'required|exists:students,id',
                'exam_id' => 'required|exists:exams,id',
                'score' => 'required|numeric|min:0',
                'remarks' => 'nullable|string|max:255',
            ]);

            $examResult = ExamResult::create($validatedData);
            return response()->json($examResult, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $examResult = ExamResult::find($id);
        if (!$examResult) {
            return response()->json(['message' => 'Exam result not found'], 404);
        }
        return response()->json($examResult, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $examResult = ExamResult::find($id);
            if (!$examResult) {
                return response()->json(['message' => 'Exam result not found'], 404);
            }

            $validatedData = $request->validate([
                'student_id' => 'sometimes|required|exists:students,id',
                'exam_id' => 'sometimes|required|exists:exams,id',
                'score' => 'sometimes|required|numeric|min:0',
                'remarks' => 'nullable|string|max:255',
            ]);

            $examResult->update($validatedData);
            return response()->json($examResult, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $examResult = ExamResult::find($id);
        if (!$examResult) {
            return response()->json(['message' => 'Exam result not found'], 404);
        }
        $examResult->delete();
        return response()->json(['message' => 'Exam result deleted successfully'], 200);
    }
}
