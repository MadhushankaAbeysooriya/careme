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
        Schema::table('patient_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_request_description_id')->nullable();
            $table->foreign('patient_request_description_id')->references('id')->on('patient_request_descriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_requests', function (Blueprint $table) {
            $table->dropForeign(['patient_request_description_id']);
            $table->dropColumn('patient_request_description_id');
        });
    }
};
