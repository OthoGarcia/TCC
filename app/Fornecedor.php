<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fornecedors';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'descricao', 'telefone', 'email'];

   public function produtos()
   {
      return $this->belongsToMany('App\Produto');
   }

   public function pedidos()
   {
      return $this->belongsToMany('App\Pedido');
   }
}
