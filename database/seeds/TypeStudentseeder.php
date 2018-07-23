<?php

use Illuminate\Database\Seeder;

class TypeStudentseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\App\Models\TypeStudents::create(['name' => 'Primera Vez']);
    	\App\Models\TypeStudents::create(['name' => 'Renovación']);
    	\App\Models\TypeStudents::create(['name' => 'Referido']);
    	\App\Models\TypeStudents::create(['name' => 'Privado a Compañía']);
    	\App\Models\TypeStudents::create(['name' => 'Compañía a Privado']);
    }
}