<?php

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Coursestate::create(['name' => 'En proceso']);
        \App\Models\Coursestate::create(['name' => 'Finalizado']);
    }
}
