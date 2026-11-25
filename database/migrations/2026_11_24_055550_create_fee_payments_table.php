<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_id')->constrained('fees')->onDelete('cascade');
            $table->string('receipt_no')->unique();
            $table->decimal('payment_amount', 10, 2);
            $table->date('payment_date');
            $table->string('payment_method')->nullable();     // cash, bkash, bank
            $table->string('transaction_reference')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};