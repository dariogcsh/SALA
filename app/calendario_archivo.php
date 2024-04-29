<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calendario_archivo extends Model
{
    protected $fillable = [
        'id_calendario','path',
    ];

    public function calendarios(){
        return $this->belongsTo('App\calendario','id_calendario','id');
    }
    public function calendario_archivos(){
        return $this->HasMany('App\calendario_archivos','id_calendario','id');
    }
}
