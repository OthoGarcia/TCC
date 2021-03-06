<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

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
    protected $fillable = ['nome', 'descricao'];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'permission_role');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'role_id');
    }

}
