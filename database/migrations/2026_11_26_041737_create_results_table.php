<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('student_enrollments')->onDelete('cascade');
            $table->foreignId('exam_subject_id')->constrained('exam_subjects')->onDelete('cascade');
            $table->decimal('obtained_marks', 5, 2)->default(0);
            $table->enum('status', ['pass', 'fail', 'absent'])->default('pass');
            $table->timestamps();

            $table->unique(['enrollment_id', 'exam_subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};