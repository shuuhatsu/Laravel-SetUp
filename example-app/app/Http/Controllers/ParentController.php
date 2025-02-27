<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentModel; // Ensure this matches your model name
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    public function index()
    {
        return response()->json(ParentModel::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|unique:parents,email',
                'password' => 'required|string|min:6',
                'fname' => 'required|string|max:45',
                'lname' => 'required|string|max:45',
                'dob' => 'required|date',
                'phone' => 'nullable|string|max:15',
                'mobile' => 'nullable|string|max:15',
                'status' => 'boolean',
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);

            $parent = ParentModel::create($validatedData);
            return response()->json($parent, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $parent = ParentModel::find($id);
        if (!$parent) {
            return response()->json(['message' => 'Parent not found'], 404);
        }
        return response()->json($parent, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $parent = ParentModel::find($id);
            if (!$parent) {
                return response()->json(['message' => 'Parent not found'], 404);
            }

            $validatedData = $request->validate([
                'email' => 'sometimes|required|email|unique:parents,email,' . $id,
                'password' => 'sometimes|required|string|min:6',
                'fname' => 'sometimes|required|string|max:45',
                'lname' => 'sometimes|required|string|max:45',
                'dob' => 'sometimes|required|date',
                'phone' => 'nullable|string|max:15',
                'mobile' => 'nullable|string|max:15',
                'status' => 'boolean',
            ]);

            if (isset($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            $parent->update($validatedData);
            return response()->json($parent, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $parent = ParentModel::find($id);
        if (!$parent) {
            return response()->json(['message' => 'Parent not found'], 404);
        }
        $parent->delete();
        return response()->json(['message' => 'Parent deleted successfully'], 200);
    }
}
