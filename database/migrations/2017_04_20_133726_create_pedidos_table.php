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
            $table->string('arquivo')->nullable();
            $table->double('total',20,2)->nullable();
            $table->date('data_efetuado')->nullable();
            $table->date('data_entregue')->nullable();
            $table->integer('fornecedor_id')->unsigned()->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
               $table->foreign('user_id')->references('id')->on('users')
                   ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('pedido_produto', function (Blueprint $table) {
           $table->integer('pedido_id')->unsigned()->nullable();
           $table->integer('produto_id')->unsigned()->nullable();
           $table->foreign('pedido_id')->references('id')->on('pedidos')
               ->onUpdate('cascade')->onDelete('cascade');
           $table->foreign('produto_id')->references('id')->on('produtos')
               ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantidade')->nullable();
            $table->integer('peso')->nullable();
            $table->double('preco',20,2);
            $table->double('sub_total',20,2);
            $table->integer('entregue')->nullable();
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
