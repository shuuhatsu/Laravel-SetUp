<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Validation\ValidationException;

class GradeController extends Controller
{
    public function index()
    {
        return response()->json(Grade::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:grades,name',
                'desc' => 'nullable|string|max:500',
            ]);

            $grade = Grade::create($validatedData);
            return response()->json($grade, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response()->json(['message' => 'Grade not found'], 404);
        }
        return response()->json($grade, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $grade = Grade::find($id);
            if (!$grade) {
                return response()->json(['message' => 'Grade not found'], 404);
            }

            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255|unique:grades,name,' . $id,
                'desc' => 'nullable|string|max:500',
            ]);

            $grade->update($validatedData);
            return response()->json($grade, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response()->json(['message' => 'Grade not found'], 404);
        }
        $grade->delete();
        return response()->json(['message' => 'Grade deleted successfully'], 200);
    }
}
