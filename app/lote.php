<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lote extends Model
{
    public function ordentrabajos(){
        return $this->HasMany('App\ordentrabajo','id_lote','id');
    }
}
