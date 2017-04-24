<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'produtos';

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
    protected $fillable = ['nome', 'descricao', 'preco', 'estoque_min','peso','quantidade'];

    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }
   public function fornecedor()
   {
      return $this->belongsTo('App\Fornecedor');
   }

   public function pedidos()
   {
      return $this->belongsToMany('App\Pedido', 'pedido_produto')
         ->withPivot('quantidade','preco','sub_total');
   }
}
