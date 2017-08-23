<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIngredientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredientes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade')->unsigned()->nullable();
            $table->integer('peso')->unsigned()->nullable();
            $table->integer('produto_id')->unsigned()->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('produto_ingrediante', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade')->unsigned()->nullable();
            $table->integer('peso')->unsigned()->nullable();
            $table->integer('produto_id')->unsigned()->nullable();
            $table->foreign('produto_id')
            ->references('id')->on('produtos')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('ingrediente_id')->unsigned()->nullable();
            $table->foreign('ingrediente_id')
            ->references('id')->on('ingredientes')
            ->onDelete('cascade')->onUpdate('cascade');
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
      Schema::drop('produto_ingrediante');
        Schema::drop('ingredientes');
    }
}
