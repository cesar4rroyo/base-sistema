<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpcionMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //start Grupo Persona
        DB::table('opcionmenu')->insert([
            'nombre' => 'Personas',
            'icono' => 'fas fa-user-alt',
            'link' => 'admin/persona',
            'orden' => 1,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Nacionalidad',
            'icono' => 'fas fa-globe-americas',
            'link' => 'admin/nacionalidad',
            'orden' => 2,
            'grupomenu_id' => 2
        ]);
        //end Grupo Persona
        //start Grupo Usuarios
        DB::table('opcionmenu')->insert([
            'nombre' => 'Usuario',
            'link' => 'admin/usuario',
            'icono' => 'fas fa-user',
            'orden' => 1,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Roles',
            'link' => 'admin/rol',
            'icono' => 'fas fa-users-cog',
            'orden' => 2,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Rol Persona',
            'icono' => 'fas fa-user-plus',
            'link' => 'admin/rolpersona',
            'orden' => 3,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Tipos Usuario',
            'icono' => 'fas fa-users-slash',
            'link' => 'admin/tipousuario',
            'orden' => 4,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Accesos',
            'link' => 'admin/acceso',
            'icono' => 'fas fa-people-arrows',
            'orden' => 3,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Opciones de Menú',
            'icono' => 'fas fa-stream',
            'link' => 'admin/opcionmenu',
            'orden' => 6,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Grupos de Menú',
            'icono' => 'fas fa-list-ol',
            'link' => 'admin/grupomenu',
            'orden' => 7,
            'grupomenu_id' => 3
        ]);
        //end Grupo Usuarios
    }
}
