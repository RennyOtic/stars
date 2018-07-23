<?php

use Illuminate\Database\Seeder;

class IdiomaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\Models\Idioma::create(['name' => 'Inglés']);
    	App\Models\Idioma::create(['name' => 'Español']);
    	App\Models\Idioma::create(['name' => 'Portugués']);
    	App\Models\Idioma::create(['name' => 'Francés']);
    }
}
