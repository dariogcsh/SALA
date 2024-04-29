<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class campo extends Model
{
    protected $fillable = [
        'org_id','field_id', 'archived', 'field_ha', 'boundary', 'adr', 'op_id', 'op_type', 'op_crop', 'op_ha',
        'op_rinde', 'op_hum', 'op_ini', 'op_fin', 'op_date',
    ];

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('organizacions.NombOrga','campos.op_fin','organizacions.CodiOrga')
                        ->join('organizacions','campos.org_id','=','organizacions.CodiOrga')
                        ->where($tipo,'LIKE',"%$buscar%")
                        ->whereIn('campos.op_fin', function ($sub) {
                            $sub->selectRaw('max(campos.op_fin)')->from('campos')->groupBy('campos.op_fin'); // <---- la clave
                        })
                        ->distinct('campos.org_id')
                        ->orderBy('campos.op_fin','desc');
        }
    }
}
