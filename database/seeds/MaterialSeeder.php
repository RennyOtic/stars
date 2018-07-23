<?php

use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\App\Models\Material::create(['name' => 'NEF']);
    	\App\Models\Material::create(['name' => 'BR']);
    	\App\Models\Material::create(['name' => 'TOEFL']);
    	\App\Models\Material::create(['name' => 'IELTS']);
    	\App\Models\Material::create(['name' => 'Prisma/AI']);
    	\App\Models\Material::create(['name' => 'Bem-Vindo']);
    	// \App\Models\Material::create(['name' => 'Otro']);
    }
}
