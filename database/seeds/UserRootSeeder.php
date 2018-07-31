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
            'from_at'       => \Carbon\Carbon::parse('08:00:00'),
            'to_at'         => \Carbon\Carbon::parse('17:00:00'),
            'special'       => 'all-access'
        ]);

        $user->roles()->attach([$rol->id]);

        $num = App\Models\Permisologia\Permission::all()->count();
        for ($i = 1; $i <= $num; $i++) { 
            DB::table('permission_role')->insert([
                'role_id' => 1,
                'permission_id' => $i
            ]);
        }

        for ($i = 1; $i <= $num; $i++) { 
            DB::table('permission_user')->insert([
                'user_id' => $user->id,
                'permission_id' => $i
            ]);
        }
    }
}
