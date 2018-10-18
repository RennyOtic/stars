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
        \App\Models\Coursestate::create(['name' => 'Por Iniciar']);
        \App\Models\Coursestate::create(['name' => 'En Proceso']);
        \App\Models\Coursestate::create(['name' => 'Finalizado']);
    }
}
