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
        \App\Models\EventAssistance::create(['name' => 'Salida']);
    }
}
