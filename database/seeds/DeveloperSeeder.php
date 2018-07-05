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

        factory(App\Models\Permisologia\Role::class, 19)->create();

        for ($i = 2; $i <= 100; $i++) { 
            DB::table('role_user')->insert([
                'user_id' => $i,
                'role_id' => rand(2, 20)
            ]);
        }
    }
}
