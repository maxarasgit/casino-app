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
    Schema::create('spins', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id'); // Who played?
        $table->string('result');    // "Heads" or "Tails"
        $table->integer('bet');      // How much did they risk?
        $table->integer('payout');   // How much did they get back?
        $table->timestamps();        // When did this happen?
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spins');
    }
};
