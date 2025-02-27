<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        return response()->json(Attendance::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'student_id' => 'required|exists:students,id',
            'status' => 'required|boolean',
            'remark' => 'nullable|string'
        ]);
        
        $attendance = Attendance::create($request->all());
        return response()->json($attendance, 201);
    }

    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);
        return response()->json($attendance, 200);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->all());
        return response()->json($attendance, 200);
    }

    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
