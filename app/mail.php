<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mail extends Model
{
    protected $fillable = [
        'OrgaMail','UserMail','TipoMail','TiInMail',
    ];

    public function organizacions(){
        return $this->belongsTo('App\organizacion', 'OrgaMail','id');
    }
    public function users(){
        return $this->belongsTo('App\User','UserMail','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('mails.id','organizacions.NombOrga', 'users.last_name', 'users.name','users.email',
                                'mails.TipoMail','mails.TiInMail')
                                ->join('organizacions', 'mails.OrgaMail','=','organizacions.id')
                                ->join('users','mails.UserMail','=','users.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
