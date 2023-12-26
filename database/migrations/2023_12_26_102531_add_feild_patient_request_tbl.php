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
            $table->dateTime('from');
            $table->dateTime('to');
            $table->unsignedBigInteger('care_taker_id');
            $table->foreign('care_taker_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('hrs',12,1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_requests', function (Blueprint $table) {
            $table->dropColumn('from');
            $table->dropColumn('to');
            $table->dropColumn('care_taker_id');
            $table->dropColumn('hrs',12,1);
        });
    }
};
