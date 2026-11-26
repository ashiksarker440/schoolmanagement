<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_id')->unique()->nullable();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->integer('mark_type')->default(1);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        //drop the the relationship with exam_subjects table before dropping subjects table
        Schema::table('exam_subjects', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
        });
        Schema::dropIfExists('subjects');
    }
};