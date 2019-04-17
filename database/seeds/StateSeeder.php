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
        \App\Models\CourseState::create(['name' => 'Por Iniciar']);
        \App\Models\CourseState::create(['name' => 'En Proceso']);
        \App\Models\CourseState::create(['name' => 'Finalizado']);
    }
}
