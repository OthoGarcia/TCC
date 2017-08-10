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
    protected $fillable = ['nome', 'descricao', 'preco', 'estoque_min','peso',
    'quantidade','peso_quantidade','total','cod_barras'];

    public function categorias()
    {
        return $this->belongsToMany('App\Categoria','categorias_produtos');
    }
   public function fornecedor()
   {
      return $this->belongsTo('App\Fornecedor');
   }

   public function pedidos()
   {
      return $this->belongsToMany('App\Pedido', 'pedido_produto')
         ->withPivot('quantidade','preco','peso','sub_total','entregue')
         ->withTimestamps()
         ->orderBy('pedido_produto.updated_at','desc');
   }
}
