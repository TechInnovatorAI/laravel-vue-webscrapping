<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAthleteRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athlete_rankings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255);
            $table->string('club_name', 255)->nullable();
            $table->string('country', 25)->nullable();
            $table->string('tournament_id', 255)->nullable();
            $table->integer('year')->nullable();
            $table->string('category', 255);
            $table->string('weight', 255)->nullable();
            $table->string('official_ranking', 255)->nullable();
            $table->string('ranking1', 255)->nullable();
            $table->string('ranking2', 255)->nullable();
            $table->string('win', 255)->nullable();
            $table->string('lose', 255)->nullable();
            $table->string('difference', 255)->nullable();
            $table->string('point_scored', 255)->nullable();
            $table->string('point_suffered', 255)->nullable();
            $table->string('point_diff', 255)->nullable();
            $table->text('matches')->nullable();
            $table->integer('fattore')->default(0);
            $table->string('tournament_name', 255)->nullable();
            $table->string('weight_group', 255)->nullable();
            $table->string('category_group', 255)->nullable();
            $table->string('male_female', 255)->nullable();
            $table->string('t_id', 255)->nullable();
            $table->string('t_name', 255)->nullable();
            $table->string('title', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('athlete_rankings');
    }
}
