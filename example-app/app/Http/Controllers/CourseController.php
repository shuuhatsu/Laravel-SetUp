<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'description' => 'nullable|string'
        ]);

        $course = Course::create($validated);
        return response()->json($course, 201);
    }

    public function show($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }
        return response()->json($course, 200);
    }

    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:50|unique:courses,code,' . $id,
            'description' => 'nullable|string'
        ]);

        $course->update($validated);
        return response()->json($course, 200);
    }

    public function destroy($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $course->delete();
        return response()->json(['message' => 'Course deleted successfully'], 200);
    }
}
