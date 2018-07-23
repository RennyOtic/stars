<?php

use Illuminate\Database\Seeder;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\ClassType::create(['name' => 'Grupal']);
        App\Models\ClassType::create(['name' => 'Individual']);
    }
}
