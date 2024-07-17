<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsInTournamentMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournament_matches', function (Blueprint $table) {
            $table->string('player1_is_free_win')->nullable();
            $table->string('player2_is_free_win')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournament_matches_tables', function (Blueprint $table) {
            //
        });
    }
}
