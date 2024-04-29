<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mant_maq extends Model
{
    protected $fillable = [
        'id_paquetemant','pin','realizado','horas','fecha','estado'
    ];

    public function paquetemants(){
        return $this->belongsTo('App\paquetemant','id_paquetemant','id');
    }
}
