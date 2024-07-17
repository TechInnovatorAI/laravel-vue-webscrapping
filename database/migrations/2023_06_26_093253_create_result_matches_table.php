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
        Schema::create('result_matches', function (Blueprint $table) {
            $table->id();
            $table->integer('result_tournament_id');
            $table->string('category');
            $table->string('rank');
            $table->string('trophy')->nullable();
            $table->string('name');
            $table->string('club');
            $table->string('matchId');
            $table->string('pti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_matches');
    }
};
