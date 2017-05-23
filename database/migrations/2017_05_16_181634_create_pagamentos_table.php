<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('pagamentos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->string('Tipo');
            $table->double('valor',20,2);
            $table->integer('parcela')->nullable();
            $table->date('data');
            $table->boolean('pago');
            $table->string('forma')->default(false);
            $table->integer('pedido_id')->unsigned()->nullable();
            $table->foreign('pedido_id')->references('id')->on('pedidos')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('pagamentos');
    }
}
