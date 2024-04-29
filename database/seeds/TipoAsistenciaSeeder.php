<?php

use Illuminate\Database\Seeder;
use App\asistenciatipo;
use App\permissions\Models\Permission;
use App\permissions\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TipoAsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //-----------TIPO ASISTENCIA------------

      $permission = Permission::create([
        'name'=>'Ver tipo de asistencia',
        'slug'=>'asistenciatipo.index',
        'description'=>'El usuario puede ver los tipo de asistencias'
    ]);

    $permission_all[] = $permission->id;

    
    $permission = Permission::create([
        'name'=>'Detalles de tipo de asistencia',
        'slug'=>'asistenciatipo.show',
        'description'=>'El usuario puede ver un tipo de asistencia'
    ]);

    $permission_all[] = $permission->id;


    $permission = Permission::create([
        'name'=>'Crear tipo de asistencias',
        'slug'=>'asistenciatipo.create',
        'description'=>'El usuario puede crear tipo de asistencias'
    ]);

    $permission_all[] = $permission->id;

    $permission = Permission::create([
        'name'=>'Editar tipos de asistencias',
        'slug'=>'asistenciatipo.edit',
        'description'=>'El usuario puede editar los tipos de asistencias'
    ]);

    $permission_all[] = $permission->id;
    
    $permission = Permission::create([
        'name'=>'Eliminar tipo de asistencia',
        'slug'=>'asistenciatipo.destroy',
        'description'=>'El usuario puede eliminar los tipos de asistencias'
    ]);

    $permission_all[] = $permission->id;

    $permission = Permission::create([
        'name'=>'Crear calificacion',
        'slug'=>'calificacion.create',
        'description'=>'El usuario puede calificar los servicios de asistencia'
    ]);

    $permission_all[] = $permission->id;

    $permission = Permission::create([
        'name'=>'Ver calificacion',
        'slug'=>'calificacion.index',
        'description'=>'El usuario puede ver las calificaciones de los servicios de asistencia'
    ]);

    $permission_all[] = $permission->id;
    }
}
