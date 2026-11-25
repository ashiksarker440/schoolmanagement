<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fee_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_id')->constrained('fees')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('student_enrollments')->onDelete('cascade');
            $table->foreignId('fee_category_id')->nullable()->constrained('fee_categories')->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_details');
    }
};
