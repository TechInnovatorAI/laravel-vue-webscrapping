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
        Schema::create('pool_round_matches', function (Blueprint $table) {
            $table->id();
            $table->integer('pool_round_id');
            $table->integer('player1_id'); // pool_round_record_id
            $table->integer('player2_id'); // pool_round_record_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pool_round_matches');
    }
};
