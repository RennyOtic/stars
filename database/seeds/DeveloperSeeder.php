<?php

use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();

        factory(App\User::class, 99)->create();

        for ($i = 2; $i <= 100; $i++) { 
            DB::table('role_user')->insert([
                'user_id' => $i,
                'role_id' => rand(2, 4)
            ]);
        }

        $permissions = [16, 22, 23, 24];
        $rol = \App\Models\Permisologia\Role::findOrFail(3);
        $rol->permissions()->attach($permissions);
        $users = $rol->users;
        $users->each(function ($u) use ($permissions) {
            $u->permissions()->attach($permissions);
        });

        factory(App\Models\Company::class, 10)->create();

        factory(App\Models\Course::class, 50)->create();

        DB::table('course_user')->insert([
            'user_id' => 1,
            'course_id' => 1
        ]);
    }
}
