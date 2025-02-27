<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamType;
use Illuminate\Validation\ValidationException;

class ExamTypeController extends Controller
{
    public function index()
    {
        return response()->json(ExamType::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:exam_types,name',
                'description' => 'nullable|string|max:500',
            ]);

            $examType = ExamType::create($validatedData);
            return response()->json($examType, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $examType = ExamType::find($id);
        if (!$examType) {
            return response()->json(['message' => 'Exam type not found'], 404);
        }
        return response()->json($examType, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $examType = ExamType::find($id);
            if (!$examType) {
                return response()->json(['message' => 'Exam type not found'], 404);
            }

            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255|unique:exam_types,name,' . $id,
                'description' => 'nullable|string|max:500',
            ]);

            $examType->update($validatedData);
            return response()->json($examType, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $examType = ExamType::find($id);
        if (!$examType) {
            return response()->json(['message' => 'Exam type not found'], 404);
        }
        $examType->delete();
        return response()->json(['message' => 'Exam type deleted successfully'], 200);
    }
}
