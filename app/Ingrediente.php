<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ingredientes';

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
    protected $fillable = ['peso', 'quantidade'];
    public function produto()
    {
      return $this->belongsTo('App\Produto');
    }

    public function produtos()
	{
      return $this->belongsToMany('App\Produto', 'produto_ingrediante')
      ->withPivot('quantidade','peso')
      ->withTimestamps();
	}

}
