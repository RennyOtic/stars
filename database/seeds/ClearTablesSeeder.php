<?php

use Illuminate\Database\Seeder;

class ClearTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('password_resets')->truncate();
        DB::table('role_user')->truncate();
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('permissions')->truncate();
        DB::table('course_days')->truncate();
        DB::table('course_states')->truncate();
        DB::table('course_user')->truncate();
        DB::table('days')->truncate();
        DB::table('type_students')->truncate();
        DB::table('idiomas')->truncate();
        DB::table('levels')->truncate();
        DB::table('class_types')->truncate();
        DB::table('materials')->truncate();
        DB::table('courses')->truncate();
        DB::table('event_assistances')->truncate();
        DB::table('assistances_controls')->truncate();
        DB::table('assistances')->truncate();
        DB::table('notifications')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}