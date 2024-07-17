<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrawLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draw_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('link');
            $table->text('url');
            $table->string('tourId');
            $table->string('year');
            $table->string('t_name');
            $table->string('fattore');
            $table->string('t_id');
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
        Schema::dropIfExists('draw_links');
    }
}
