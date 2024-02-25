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
        Schema::table('complains', function (Blueprint $table) {
            $table->string('remarks')->nullable();

            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->foreign('resolved_by')->references('id')->on('users')->onDelete('cascade');

            $table->dateTime('resolved_at')->nullable()->comment("resolving time");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complains', function (Blueprint $table) {
            $table->dropColumn('remarks');

            $table->dropForeign(['resolved_by']);
            $table->dropColumn('resolved_by');

            $table->dropColumn('resolved_at');
        });
    }
};
