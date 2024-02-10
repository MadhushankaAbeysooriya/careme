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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->unsignedBigInteger('advertisement_category_id')->nullable();
            $table->foreign('advertisement_category_id')->references('id')->on('advertisement_categories')->onDelete('cascade');

            $table->decimal('amount',10,2)->nullable();
            $table->decimal('total',12,2)->nullable();
            $table->string('url')->nullable();

            $table->dateTime('from')->nullable();
            $table->dateTime('to')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropForeign(['advertisement_category_id']);
            $table->dropColumn('advertisement_category_id');

            $table->dropColumn('amount');
            $table->dropColumn('total');
            $table->dropColumn('url');

            $table->dropColumn('from');
            $table->dropColumn('to');
        });
    }
};
