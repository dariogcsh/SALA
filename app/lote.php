<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lote extends Model
{
    protected $fillable = [
        'org_id','farm', 'farm', 'name','client','field_ha',
     ];

     public function clientes(){
        return $this->belongsTo('App\cliente','id_cliente','id');
    }
    public function ordentrabajos(){
        return $this->HasMany('App\ordentrabajo','id_lote','id');
    }
}
