<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_request_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_request_id');
            $table->foreign('patient_request_id')->references('id')->on('patient_requests')->onDelete('cascade');
            $table->string('filepath');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_request_payments');
    }
};
