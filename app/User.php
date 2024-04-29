<?php

namespace App;

use App\Notifications\UserResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\permissions\traits\UserTrait;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable
{
    use Notifiable, UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'TeleUser', 'TokenNotificacion','password','CodiOrga','CodiSucu','CodiPuEm', 'doble_check'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPassword($token));
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('users.id','users.name','users.last_name','organizacions.NombOrga','sucursals.NombSucu',
                                'users.TokenNotificacion')
                        ->leftjoin('organizacions','users.CodiOrga','=','organizacions.id')
                        ->leftjoin('sucursals','users.CodiSucu','=','sucursals.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }


    // Relaciones con otras tablas
    public function sucursals(){
        return $this->belongsTo('App\sucursal', 'CodiSucu','id');
    }
    public function organizacions(){
        return $this->belongsTo('App\organizacion', 'CodiOrga','id');
    }
    public function puestoemps(){
        return $this->belongsTo('App\puesto_empleado', 'CodiPuEm','id');
    }
    public function asists(){
        return $this->HasMany('App\asist','id_user','id');
    }
    public function solucions(){
        return $this->HasMany('App\solucion','id_user','id');
    }
    public function notifications(){
        return $this->HasMany('App\user_notification','id_user','id');
    }
    public function mails(){
        return $this->HasMany('App\mail','UserMail','id');
    }
    public function usados(){
        return $this->HasMany('App\usado','id_user','id');
    }
    public function contactos(){
        return $this->HasMany('App\contacto','id_user','id');
    }
    public function users_proyectos(){
        return $this->HasMany('App\users_proyecto','id_user','id');
    }
    public function entrega_pasos(){
        return $this->HasMany('App\entrega_paso','id_user','id');
    }
    public function ordentrabajos(){
        return $this->HasMany('App\ordentrabajo','id_usuarioorden','id');
        return $this->HasMany('App\ordentrabajo','id_usuariotrabajo','id');
    }
    public function calendario_users(){
        return $this->HasMany('App\calendario_user','id_user','id');
    }
    public function capacitacion_users(){
        return $this->HasMany('App\capacitacion_user','id_user','id');
    }
    public function viaje_users(){
        return $this->HasMany('App\viaje_user','id_user','id');
    }
    public function senals(){
        return $this->HasMany('App\senal','id_user','id');
    }
    public function activacions(){
        return $this->HasMany('App\activacion','id_user','id');
    }
    
}
