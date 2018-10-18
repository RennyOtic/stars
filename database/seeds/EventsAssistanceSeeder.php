<?php

use Illuminate\Database\Seeder;

class EventsAssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EventAssistance::create(['name' => 'Entrada']);
        \App\Models\EventAssistance::create(['name' => 'Sigue']);
        \App\Models\EventAssistance::create(['name' => 'Salida']);
        \App\Models\EventAssistance::create(['name' => 'Suspensión']);
        \App\Models\EventAssistance::create(['name' => 'Cancelación']);
        \App\Models\EventAssistance::create(['name' => 'Vacaciones']);
        \App\Models\EventAssistance::create(['name' => 'Licencia']);
        \App\Models\EventAssistance::create(['name' => 'Otro']);
    }
}
