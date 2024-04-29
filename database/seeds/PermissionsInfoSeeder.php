<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Organizacion;
use App\Sucursal;
use App\Puesto_empleado;

use App\permissions\Models\Permission;
use App\permissions\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PermissionsInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacio las tablas muchos a muchos
        DB::statement("SET foreign_key_checks=0");
        DB::table('role_user')->truncate();
        DB::table('permission_role')->truncate();
        Permission::truncate();
        Role::truncate();
        Sucursal::truncate();
        DB::statement("SET foreign_key_checks=1");

        //sucursal
        $sucursal_all = [];

        //sucursal
        $sucursal = Sucursal::create([
            'NombSucu'  =>  'Coronel Moldes'
        ]);
        $sucursal_all[] = $sucursal->id;

        $sucursal = Sucursal::create([
            'NombSucu'  =>  'Vicuña Mackenna'
        ]);
        $sucursal_all[] = $sucursal->id;

        $sucursal = Sucursal::create([
            'NombSucu'  =>  'Adelia Maria'
        ]);
        $sucursal_all[] = $sucursal->id;

        $sucursal = Sucursal::create([
            'NombSucu'  =>  'Villa Mercedes'
        ]);
        $sucursal_all[] = $sucursal->id;

        $sucursal = Sucursal::create([
            'NombSucu'  =>  'Rio Cuarto'
        ]);
        $sucursal_all[] = $sucursal->id;

        $sucursal = Sucursal::create([
            'NombSucu'  =>  'La Carlota'
        ]);
        $sucursal_all[] = $sucursal->id;


        //organizacion
        $organizacion = Organizacion::create([
            'CodiOrga'=>'99',
            'NombOrga'=>'Sala Hnos',
            'CodiSucu'=>'1',
            'InscOrga'=>'NO'
        ]);
        //puesto
        $puesto = Puesto_empleado::create([
            'NombPuEm'=>'Cliente'
        ]);

        //user admin
        $useradmin = User::where('email','admin@admin.com')->first();
        if ($useradmin){
            $useradmin->delete();
        }
        $useradmin = User::create([
            'name' => 'Dario',
            'last_name' => 'Garcia Campi',
            'TeleUser' => '3584221996',
            'email' => 'admin@admin.com',
            'TokenNotificacion' =>'1',
            'password' => Hash::make('admin'),
            'CodiOrga' => '1',
            'CodiPuEm' => '1',
            'CodiSucu' => '1',
        ]);
        
        //Rol admin
         $roladmin = Role::create([
            'name'=>'Admin',
            'slug'=>'admin',
            'description'=>'Administrador Sala',
            'full-access'=>'yes'
        ]);

        //Rol Registered User
        $roluser = Role::create([
            'name'=>'Usuario registrado',
            'slug'=>'registereduser',
            'description'=>'Usuario registrado sin asignar',
            'full-access'=>'no'
        ]);
        
        //table role_user
        $useradmin->roles()->sync([$roladmin->id]);

        //permission
        $permission_all = [];

        //permission role
        $permission = Permission::create([
            'name'=>'Ver roles',
            'slug'=>'role.index',
            'description'=>'El usuario puede ver los roles'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Detalle de rol',
            'slug'=>'role.show',
            'description'=>'El usuario puede ver un rol'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Crear roles',
            'slug'=>'role.create',
            'description'=>'El usuario puede crear roles'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Editar roles',
            'slug'=>'role.edit',
            'description'=>'El usuario puede editar los roles'
        ]);

        $permission_all[] = $permission->id;


        $permission = Permission::create([
            'name'=>'Eliminar roles',
            'slug'=>'role.destroy',
            'description'=>'El usuario puede eliminar los roles'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Ver usuarios',
            'slug'=>'user.index',
            'description'=>'El usuario puede ver los usuarios'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Detalles de usuario',
            'slug'=>'user.show',
            'description'=>'El usuario puede ver un usuario'
        ]);

        $permission_all[] = $permission->id;

        /*
        $permission = Permission::create([
            'name'=>'Create user',
            'slug'=>'user.index',
            'description'=>'El usuario puede crear usuarios'
        ]);

        $permission_all[] = $permission->id;

        */
        $permission = Permission::create([
            'name'=>'Editar usuarios',
            'slug'=>'user.edit',
            'description'=>'El usuario puede editar los usuarios'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Detalles de mi usuario',
            'slug'=>'userown.show',
            'description'=>'El usuario puede ver mi usuario'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Editar mi usuario',
            'slug'=>'userown.edit',
            'description'=>'El usuario puede editar su propio usuarios'
        ]);

        $permission_all[] = $permission->id;

        
        
        $permission = Permission::create([
            'name'=>'Eliminar usuarios',
            'slug'=>'user.destroy',
            'description'=>'El usuario puede eliminar los usuarios'
        ]);

        $permission_all[] = $permission->id;

        //table permission_role
        //$roladmin->permissions()->sync($permission_all);
        
        
        //------------PANTALLA y ANTENA------------

        $permission = Permission::create([
            'name'=>'Ver pantalla',
            'slug'=>'pantalla.index',
            'description'=>'El usuario puede ver las pantallas'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Detalles de pantalla',
            'slug'=>'pantalla.show',
            'description'=>'El usuario puede ver una pantalla'
        ]);

        $permission_all[] = $permission->id;

    
        $permission = Permission::create([
            'name'=>'Crear pantalla',
            'slug'=>'pantalla.create',
            'description'=>'El usuario puede crear pantallas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Editar pantalla',
            'slug'=>'pantalla.edit',
            'description'=>'El usuario puede editar las pantallas'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Eliminar pantallas',
            'slug'=>'pantalla.destroy',
            'description'=>'El usuario puede eliminar las pantallas'
        ]);

        $permission_all[] = $permission->id;


        $permission = Permission::create([
            'name'=>'Ver antenas',
            'slug'=>'antena.index',
            'description'=>'El usuario puede ver las antenas'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Detalles de antena',
            'slug'=>'antena.show',
            'description'=>'El usuario puede ver una antena'
        ]);

        $permission_all[] = $permission->id;

    
        $permission = Permission::create([
            'name'=>'Crear antena',
            'slug'=>'antena.create',
            'description'=>'El usuario puede crear antenas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Editar antena',
            'slug'=>'antena.edit',
            'description'=>'El usuario puede editar las antenas'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Eliminar antena',
            'slug'=>'antena.destroy',
            'description'=>'El usuario puede eliminar las antenas'
        ]);

        $permission_all[] = $permission->id;




        //------------MAQUINA--------------
        $permission = Permission::create([
            'name'=>'Ver maquinas',
            'slug'=>'maquina.index',
            'description'=>'El usuario puede ver las maquinas'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Detalles de maquina',
            'slug'=>'maquina.show',
            'description'=>'El usuario puede ver una maquina'
        ]);

        $permission_all[] = $permission->id;

    
        $permission = Permission::create([
            'name'=>'Crear maquinas',
            'slug'=>'maquina.create',
            'description'=>'El usuario puede crear maquinas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Editar maquinas',
            'slug'=>'maquina.edit',
            'description'=>'El usuario puede editar las maquinas'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Detalles de mi maquina',
            'slug'=>'maquinaown.show',
            'description'=>'El usuario puede ver mi maquina'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Editar mi maquina',
            'slug'=>'maquinaown.edit',
            'description'=>'El usuario puede editar su propia maquina'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Eliminar maquinas',
            'slug'=>'maquina.destroy',
            'description'=>'El usuario puede eliminar las maquinas'
        ]);

        $permission_all[] = $permission->id;





        //--------Sucursales----------


        $permission = Permission::create([
            'name'=>'Ver sucursales',
            'slug'=>'sucursal.index',
            'description'=>'El usuario puede ver las sucursales'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Detalles de sucursal',
            'slug'=>'sucursal.show',
            'description'=>'El usuario puede ver una sucursal'
        ]);

        $permission_all[] = $permission->id;

    
        $permission = Permission::create([
            'name'=>'Crear sucursales',
            'slug'=>'sucursal.create',
            'description'=>'El usuario puede crear sucursales'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Editar sucursales',
            'slug'=>'sucursal.edit',
            'description'=>'El usuario puede editar las sucursales'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Eliminar sucursales',
            'slug'=>'sucursal.destroy',
            'description'=>'El usuario puede eliminar las sucursales'
        ]);

        $permission_all[] = $permission->id;



        //-----------Organizaciones---------------

        $permission = Permission::create([
            'name'=>'Ver organizaciones',
            'slug'=>'organizacion.index',
            'description'=>'El usuario puede ver las organizaciones'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Detalles de organizacion',
            'slug'=>'organizacion.show',
            'description'=>'El usuario puede ver una organizacion'
        ]);

        $permission_all[] = $permission->id;

    
        $permission = Permission::create([
            'name'=>'Crear organizaciones',
            'slug'=>'organizacion.create',
            'description'=>'El usuario puede crear organizaciones'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Editar organizaciones',
            'slug'=>'organizacion.edit',
            'description'=>'El usuario puede editar las organizaciones'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Detalles de mi organizacion',
            'slug'=>'organizacionown.show',
            'description'=>'El usuario puede ver mi organizacion'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Editar mi organizacion',
            'slug'=>'organizacionown.edit',
            'description'=>'El usuario puede editar su propia organizacion'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Eliminar organizaciones',
            'slug'=>'organizacion.destroy',
            'description'=>'El usuario puede eliminar las organizaciones'
        ]);

        $permission_all[] = $permission->id;


        $permission = Permission::create([
            'name'=>'Ver puestos de empleados',
            'slug'=>'puesto_empleado.index',
            'description'=>'El usuario puede ver los puestos de empleados'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Detalles de puesto de empleado',
            'slug'=>'puesto_empleado.show',
            'description'=>'El usuario puede ver en detalle un puesto de empleado'
        ]);

        $permission_all[] = $permission->id;

    
        $permission = Permission::create([
            'name'=>'Crear puestos de empleados',
            'slug'=>'puesto_empleado.create',
            'description'=>'El usuario puede crear puestos de empleados'
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'=>'Editar puestos de empleados',
            'slug'=>'puesto_empleado.edit',
            'description'=>'El usuario puede editar los puestos de empleados'
        ]);

        $permission_all[] = $permission->id;

        
        $permission = Permission::create([
            'name'=>'Eliminar puestos de empleados',
            'slug'=>'puesto_empleado.destroy',
            'description'=>'El usuario puede eliminar un puesto de empleado'
        ]);

        $permission_all[] = $permission->id;

        
    }
}
