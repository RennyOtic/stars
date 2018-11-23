<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        App\Models\Permisologia\Role::create([
            'name'          => 'Coordinador',
            'slug'          => 'coordinador',
            'description'   => 'Perfil para Coordinadores de la empresa.',
        ]);

        App\Models\Permisologia\Role::create([
            'name'          => 'Profesor',
            'slug'          => 'profesor',
            'description'   => 'Perfil para Profesores de la empresa.',
        ]);

        App\Models\Permisologia\Role::create([
            'name'          => 'Alumno',
            'slug'          => 'alumno',
            'description'   => 'Perfil para Alumnos de la empresa.',
        ]);

    }
}
