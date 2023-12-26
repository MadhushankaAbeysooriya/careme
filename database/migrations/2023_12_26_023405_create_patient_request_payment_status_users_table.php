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
        Schema::create('patient_request_payment_status_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_req_stat_id');
            $table->foreign('patient_req_stat_id')->references('id')->on('patient_request_statuses')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_request_payment_status_users');
    }
};
