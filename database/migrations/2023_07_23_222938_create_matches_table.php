<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_id');
            $table->string('class');
            $table->string('weight');
            $table->string('male_female');
            $table->string('total_players');
            $table->string('player1_name');
            $table->string('player1_club');
            $table->string('player1_score');
            $table->string('player1_is_win');
            $table->string('player1_points_diff');
            $table->string('player2_name');
            $table->string('player2_club');
            $table->string('player2_score');
            $table->string('player2_is_win');
            $table->string('player2_points_diff');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
