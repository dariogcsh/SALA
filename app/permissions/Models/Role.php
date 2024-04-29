<?php

namespace App\permissions\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //es: desde aqui
    //en: from here

    protected $fillable = [
        'name', 'slug', 'description','full-access',
    ];

    public function users(){
        return $this->belongsToMany('App\User')->withTimesTamps();
    }

    public function permissions(){
        return $this->belongsToMany('App\permissions\Models\Permission')->withTimesTamps();
    }
    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
