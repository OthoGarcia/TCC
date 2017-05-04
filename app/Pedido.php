<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pedidos';

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
    protected $fillable = ['descricao', 'quantidade', 'preco', 'sub_total', 'estado'];

    public function produtos()
   {
      return $this->belongsToMany('App\Produto', 'pedido_produto')
         ->withPivot('quantidade','preco','sub_total');
   }
   public function fornecedor()
   {
      return $this->belongsTo('App\Fornecedor');
   }

}
