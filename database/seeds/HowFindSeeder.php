<?php

use Illuminate\Database\Seeder;

class HowFindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\HowFind::create(['name' => 'Otro']);
        \App\Models\HowFind::create(['name' => 'Facebook']);
        \App\Models\HowFind::create(['name' => 'Google']);
        \App\Models\HowFind::create(['name' => 'Instagram']);
        \App\Models\HowFind::create(['name' => 'Recomendación']);
        \App\Models\HowFind::create(['name' => 'Presencial']);
    }
}
