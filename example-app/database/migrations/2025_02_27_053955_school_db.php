<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('desc', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('description', 45)->nullable();
            $table->unsignedBigInteger('grade_id');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 45)->unique();
            $table->string('password', 45);
            $table->string('fname', 45);
            $table->string('lname', 45);
            $table->date('dob');
            $table->string('phone', 15)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('last_login_date')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('parents', function (Blueprint $table) { // ✅ Moved above students
            $table->id();
            $table->string('email', 45)->unique();
            $table->string('password', 45);
            $table->string('fname', 45);
            $table->string('lname', 45);
            $table->date('dob');
            $table->string('phone', 15)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('last_login_date')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->unsignedBigInteger('grade_id');
            $table->char('section', 2);
            $table->boolean('status')->default(true);
            $table->string('remarks', 45)->nullable();
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('email', 45)->unique();
            $table->string('password', 45);
            $table->string('fname', 45);
            $table->string('lname', 45);
            $table->date('dob');
            $table->string('phone', 15)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable(); // ✅ Ensure it's nullable
            $table->date('date_of_join')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('last_login_date')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('classroom_student', function (Blueprint $table) {
            $table->unsignedBigInteger('classroom_id');
            $table->unsignedBigInteger('student_id');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('attendance', function (Blueprint $table) {
            $table->date('date');
            $table->unsignedBigInteger('student_id');
            $table->boolean('status');
            $table->text('remark')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('exam_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('desc', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_type_id');
            $table->string('name', 45);
            $table->date('start_date');
            $table->foreign('exam_type_id')->references('id')->on('exam_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id');
            $table->string('marks', 45);
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_results');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('exam_types');
        Schema::dropIfExists('attendance');
        Schema::dropIfExists('classroom_student');
        Schema::dropIfExists('students'); // ✅ Dropped before parents
        Schema::dropIfExists('parents');
        Schema::dropIfExists('classrooms');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('grades');
    }
};