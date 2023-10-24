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
        Schema::table('users', function (Blueprint $table) {
            $table->string('deviceId')->nullable();
            $table->string('phone')->unique();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->tinyInteger('validated')->default(0);//validate->1, not-validate->0
            $table->tinyInteger('status')->default(1);//active->1, inactive->0
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deviceId');
            $table->dropColumn('phone');
            $table->dropColumn('fname');
            $table->dropColumn('lname');
            $table->dropColumn('validated');
            $table->dropColumn('status');
        });
    }
};
