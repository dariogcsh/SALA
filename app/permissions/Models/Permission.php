<?php

namespace App\permissions\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //

    protected $fillable = [
        'name', 'slug', 'description',
    ];

    public function roles(){
        return $this->belongsToMany('App\permissions\Models\Role')->withTimesTamps();
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
