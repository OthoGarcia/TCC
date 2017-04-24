<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function(Blueprint $table) {
            $table->increments('id');
            $table->text('descricao');
            $table->string('estado');
            $table->timestamps();
        });
        Schema::create('pedido_produto', function (Blueprint $table) {
           $table->integer('pedido_id')->unsigned()->nullable();
           $table->integer('produto_id')->unsigned()->nullable();
           $table->foreign('pedido_id')->references('id')->on('pedidos')
               ->onUpdate('cascade')->onDelete('cascade');
           $table->foreign('produto_id')->references('id')->on('produtos')
               ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantidade');
            $table->float('preco');
            $table->float('sub_total');
            $table->timestamps();
           $table->primary(['pedido_id', 'produto_id']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pedido_produto');
        Schema::drop('pedidos');
    }
}
