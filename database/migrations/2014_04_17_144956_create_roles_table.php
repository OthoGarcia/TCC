<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->text('descricao');
            $table->timestamps();
        });
        Schema::create('permission_role', function (Blueprint $table) {
           $table->integer('permission_id')->unsigned();
           $table->integer('role_id')->unsigned();

           $table->foreign('permission_id')->references('id')->on('permissions')
               ->onUpdate('cascade')->onDelete('cascade');
           $table->foreign('role_id')->references('id')->on('roles')
               ->onUpdate('cascade')->onDelete('cascade');

           $table->primary(['permission_id', 'role_id']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('permission_role');
      Schema::drop('roles');
    }
}
