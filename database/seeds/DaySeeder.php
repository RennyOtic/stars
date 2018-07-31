<?php

use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Day::create(['name' => 'Domingo']);
        \App\Models\Day::create(['name' => 'Lunes']);
        \App\Models\Day::create(['name' => 'Martes']);
        \App\Models\Day::create(['name' => 'Miércoles']);
        \App\Models\Day::create(['name' => 'Jueves']);
        \App\Models\Day::create(['name' => 'Viernes']);
        \App\Models\Day::create(['name' => 'Sábado']);
    }
}
