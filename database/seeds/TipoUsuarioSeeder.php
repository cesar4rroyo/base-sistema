<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id=>1 Admin Principal
        DB::table('tipousuario')->insert([
            'nombre' => 'Administrador Principal',
        ]);
        DB::table('tipousuario')->insert([
            'nombre' => 'Administrador',
        ]);     
    }
}
