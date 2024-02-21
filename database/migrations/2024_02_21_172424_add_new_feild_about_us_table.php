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
        Schema::table('about_us', function (Blueprint $table) {
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_branch');
            $table->dropColumn('account_no');
            $table->dropColumn('account_holder_name');
            $table->dropColumn('account_type');
        });
    }
};
