<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
   protected $table = 'pagamentos';

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
   protected $fillable = ['descricao', 'tipo', 'valor', 'parcela', 'data', 'forma'];

   public function pedido()
   {
      return $this->belongsTo('App\Pedido');
   }
}
