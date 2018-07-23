<?php

use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\Models\Level::create(['name' => 'Beginner']);
    	App\Models\Level::create(['name' => 'Elementary']);
    	App\Models\Level::create(['name' => 'Pre-Intermediate']);
    	App\Models\Level::create(['name' => 'Intermediate']);
    	App\Models\Level::create(['name' => 'Upper-Intermediate']);
    	App\Models\Level::create(['name' => 'Advanced']);
    	// App\Models\Level::create(['name' => 'Otro']);
    }
}
