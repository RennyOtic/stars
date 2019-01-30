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

        /* `permission_role` */
        $permission_role = [
          ['role_id' => '2','permission_id' => '1'],
          ['role_id' => '2','permission_id' => '2'],
          ['role_id' => '2','permission_id' => '3'],
          ['role_id' => '2','permission_id' => '4'],
          ['role_id' => '2','permission_id' => '6'],
          ['role_id' => '2','permission_id' => '7'],
          ['role_id' => '2','permission_id' => '8'],
          ['role_id' => '2','permission_id' => '9'],
          ['role_id' => '2','permission_id' => '11'],
          ['role_id' => '2','permission_id' => '12'],
          ['role_id' => '2','permission_id' => '13'],
          ['role_id' => '2','permission_id' => '14'],
          ['role_id' => '2','permission_id' => '15'],
          ['role_id' => '2','permission_id' => '16'],
          ['role_id' => '2','permission_id' => '17'],
          ['role_id' => '2','permission_id' => '18'],
          ['role_id' => '2','permission_id' => '19'],
          ['role_id' => '2','permission_id' => '20'],
          ['role_id' => '2','permission_id' => '21'],
          ['role_id' => '2','permission_id' => '29'],
          ['role_id' => '2','permission_id' => '30'],
          ['role_id' => '2','permission_id' => '31'],
          ['role_id' => '2','permission_id' => '32'],
          ['role_id' => '2','permission_id' => '34'],
          ['role_id' => '2','permission_id' => '35'],
          ['role_id' => '2','permission_id' => '36'],
          ['role_id' => '2','permission_id' => '37'],
          ['role_id' => '2','permission_id' => '38'],
          ['role_id' => '2','permission_id' => '39'],
          ['role_id' => '3','permission_id' => '16'],
          ['role_id' => '3','permission_id' => '22'],
          ['role_id' => '3','permission_id' => '23'],
          ['role_id' => '3','permission_id' => '24'],
          ['role_id' => '3','permission_id' => '25'],
          ['role_id' => '3','permission_id' => '28'],
          ['role_id' => '3','permission_id' => '34'],
          ['role_id' => '3','permission_id' => '35'],
          ['role_id' => '3','permission_id' => '36'],
          ['role_id' => '3','permission_id' => '38'],
          ['role_id' => '4','permission_id' => '22'],
          ['role_id' => '4','permission_id' => '23'],
          ['role_id' => '4','permission_id' => '24'],
          ['role_id' => '4','permission_id' => '26'],
          ['role_id' => '4','permission_id' => '27'],
          ['role_id' => '4','permission_id' => '34'],
          ['role_id' => '4','permission_id' => '35'],
          ['role_id' => '4','permission_id' => '36'],
          ['role_id' => '4','permission_id' => '37'],
          ['role_id' => '4','permission_id' => '38']
      ];
      DB::table('permission_role')->insert($permission_role);

  }
}
