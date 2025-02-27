<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClassroomStudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\ExamTypeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::middleware('auth:sanctum')->group(function () {

    // Classroom Routes
    Route::apiResource('classrooms', ClassroomController::class);

    // Classroom Student Routes
    Route::apiResource('classroom-students', ClassroomStudentController::class);

    // Course Routes
    Route::apiResource('courses', CourseController::class);

    // Exam Routes
    Route::apiResource('exams', ExamController::class);

    // Exam Result Routes
    Route::apiResource('exam-results', ExamResultController::class);

    // Exam Type Routes
    Route::apiResource('exam-types', ExamTypeController::class);

    // Grade Routes
    Route::apiResource('grades', GradeController::class);

    // Parent Routes
    Route::apiResource('parents', ParentController::class);

    // Student Routes
    Route::apiResource('students', StudentController::class);

    // Teacher Routes
    Route::apiResource('teachers', TeacherController::class);
});

// Authentication-related routes (if needed)
Route::post('/login', [StudentController::class, 'login']); // Example for login
Route::post('/register', [StudentController::class, 'store']); // Example for registration

