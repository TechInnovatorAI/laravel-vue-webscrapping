<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInAthelteRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('athlete_rankings', function (Blueprint $table) {
            $table->string('tournament_name')->nullable();
            $table->string('weight_group')->nullable();
            $table->string('category_group')->nullable();
            $table->string('male_female')->nullable();
            $table->string('t_id')->nullable();
            $table->string('t_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('athlete_rankings', function (Blueprint $table) {
            //
        });
    }
}
