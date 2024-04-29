<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sucursal extends Model
{
    //
    protected $fillable = [
        'NombSucu',
    ];

    public function organizacions(){
        return $this->HasMany('App\organizacion','CodiSucu','id')->withTimesTamps();
    }
    public function users(){
        return $this->HasMany('App\User','CodiSucu','id')->withTimesTamps();
    }
    public function usados(){
        return $this->HasMany('App\usado','id_sucursal','id');
    }
    public function guardiasadmins(){
        return $this->HasMany('App\guardiasadmin','id_sucursal','id');
    }
    public function entregas(){
        return $this->HasMany('App\entrega','id_sucursal','id');
    }
    public function calendarios(){
        return $this->HasMany('App\calendario','id_sucursal','id');
    }
    public function reclamos(){
        return $this->HasMany('App\reclamo','id_sucursal','id');
    }
}
