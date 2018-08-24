<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::create([
            'name'      => 'Root',
            'last_name' => 'Root',
            'num_id'    => '99999999',
            'email'     => 'root@smoothtalkers.com',
            'password'  => bcrypt('secret'),
            'birthday_date' => \Carbon::now(),
            'nationality_id' => 1,
            'occupation' => 'Developer',
            'phone_home' => rand(10000, 90000) . rand(10000, 90000),
            'phone_movil' => rand(10000, 90000) . rand(10000, 90000),
        ]);

        $rol = App\Models\Permisologia\Role::create([
            'name'          => 'Administrador',
            'slug'          => 'SuperAdmin',
            'description'   => 'Rol con acceso total a los Módulos.',
            'special'       => 'all-access'
        ]);

        $user->roles()->attach([$rol->id]);

        $num = App\Models\Permisologia\Permission::all()->count();
        $data = [];
        $data2 = [];
        for ($i = 1; $i <= $num; $i++) { 
            $data[] = ['role_id' => 1, 'permission_id' => $i];
            $data2[] = ['user_id' => $user->id, 'permission_id' => $i];
        }
        DB::table('permission_role')->insert($data);
        DB::table('permission_user')->insert($data2);
    }
}
