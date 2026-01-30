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
            // Adds a 'chips' column that starts at 1000 for every user
            $table->integer('chips')->default(1000);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // This allows you to roll back the database changes if needed
            $table->dropColumn('chips');
        });
    }
};
