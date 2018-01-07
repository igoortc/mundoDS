<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('name');
            $table->integer('show_id')->unsigned();
            $table->integer('season');
            $table->integer('number');
            $table->string('synopsis');
            $table->date('date_aired');
            $table->string('image');
            $table->timestamps();

            $table->foreign('show_id')
                ->references('id')->on('shows')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
}
