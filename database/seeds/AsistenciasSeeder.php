<?php

use Illuminate\Database\Seeder;
use App\asist;
use App\permissions\Models\Permission;
use App\permissions\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AsistenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //-----------solicitud ASISTENCIA------------

      $permission = Permission::create([
        'name'=>'Ver solicitud de asistencia',
        'slug'=>'asist.index',
        'description'=>'El usuario puede ver las solicitudes de asistencias'
    ]);

    $permission_all[] = $permission->id;



    $permission = Permission::create([
        'name'=>'Crear solicitud de asistencias',
        'slug'=>'asist.create',
        'description'=>'El usuario puede crear solicitudes de asistencias'
    ]);

    $permission_all[] = $permission->id;

    $permission = Permission::create([
        'name'=>'Finalizar asistencias',
        'slug'=>'asist.edit',
        'description'=>'El usuario puede finalizar las asistencias'
    ]);

    $permission_all[] = $permission->id;

    }
}
