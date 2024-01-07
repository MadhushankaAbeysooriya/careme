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
            $table->unsignedBigInteger('relation_id')->nullable();
            $table->foreign('relation_id')->references('id')->on('relations')->onDelete('cascade');
            $table->string('refree_name');
            $table->string('refree_contact_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('care_taker_profiles', function (Blueprint $table) {
            $table->dropColumn('relation_id');
            $table->dropColumn('refree_name');
            $table->dropColumn('refree_contact_number');
        });
    }
};
