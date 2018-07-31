<?php

use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Nationality::create(['name' => 'Chile']);
        \App\Models\Nationality::create(['name' => 'Venezuela']);
    }
}
