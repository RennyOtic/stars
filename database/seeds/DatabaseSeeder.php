<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearTablesSeeder::class);
        $this->call(NationalitySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UserRootSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(TypeStudentseeder::class);
        $this->call(IdiomaSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(ClassTypeSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(DaySeeder::class);
        $this->call(HowFindSeeder::class);
        $this->call(EventsAssistanceSeeder::class);
        $this->call(DeveloperSeeder::class);
    }
}