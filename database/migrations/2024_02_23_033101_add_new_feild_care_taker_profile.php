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
        Schema::table('care_taker_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('bill_proof_id')->nullable();
            $table->foreign('bill_proof_id')->references('id')->on('bill_proofs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('care_taker_profiles', function (Blueprint $table) {
            $table->dropForeign(['bill_proof_id']);
            $table->dropColumn('bill_proof_id');
        });
    }
};
