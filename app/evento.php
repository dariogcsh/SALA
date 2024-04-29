<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class evento extends Model
{
    protected $fillable = [
        'nombre',
    ];
    public function calendarios(){
        return $this->HasMany('App\calendario','id_calendario','id');
    }
}
