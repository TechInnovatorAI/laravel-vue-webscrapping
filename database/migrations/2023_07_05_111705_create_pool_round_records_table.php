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
        Schema::create('pool_round_records', function (Blueprint $table) {
            $table->id();
            $table->integer('pool_round_id');
            $table->string('player_name');
            $table->string('info')->nullable();
            $table->string('country')->nullable();
            $table->text('flag_url')->nullable();
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pool_round_records');
    }
};
