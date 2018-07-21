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
            'name'          => 'Profesor',
            'slug'          => 'Profesor',
            'description'   => 'Rol para Profesores de la empresa.',
        ]);

        App\Models\Permisologia\Role::create([
            'name'          => 'Alumno',
            'slug'          => 'Alumno',
            'description'   => 'Rol para Alumnos de la empresa.',
        ]);

        App\Models\Permisologia\Role::create([
            'name'          => 'Coordinador',
            'slug'          => 'Coordinador',
            'description'   => 'Rol para Coordinadores de la empresa.',
        ]);
    }
}
