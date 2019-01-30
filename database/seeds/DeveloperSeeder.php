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
            $rol = rand(2, 4);
            DB::table('role_user')->insert([
                'user_id' => $i,
                'role_id' => $rol
            ]);
            \App\User::findOrFail($i)->assignPermissionsOneUser([$rol]);
        }

        factory(App\Models\Company::class, 10)->create();

        factory(App\Models\Course::class, 50)->create();

        DB::table('course_user')->insert([
            'user_id' => 1,
            'course_id' => 1
        ]);
    }
}
