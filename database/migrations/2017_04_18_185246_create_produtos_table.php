<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('categoria_id')->unsigned()->nullable();
            $table->foreign('categoria_id')->references('id')->on('categorias')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('fornecedor_id')->unsigned()->nullable();
               $table->foreign('fornecedor_id')->references('id')->on('fornecedors')
                   ->onUpdate('cascade')->onDelete('cascade');
            $table->string('nome');
            $table->text('descricao');
            $table->float('preco');
            $table->integer('estoque_min');
            $table->integer('quantidade')->nullable();
            $table->integer('peso')->nullable();
            $table->bigInteger('peso_quantidade')->nullable();
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
        Schema::drop('produtos');
    }
}
