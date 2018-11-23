<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
	$emails = [
		'@gmail.com', '@hotmail.com',
		'@mail.com', '@outlook.com',
		'@yahoo.com', '@smoothtalkers.com'
	];
	$name = $faker->firstName;
	$user = $faker->bothify($name.'#?##?');
	return [
		'name' => $name,
		'last_name' => $faker->lastName,
		'num_id' => rand(500000, 50000000),
		'email' => $user . $emails[rand(0, 5)],
		'password' => bcrypt('secret'),
		'remember_token' => str_random(10),
		'birthday_date' => \Carbon::create(rand(1950, 2018), rand(0, 12), rand(0, 31), rand(0, 24), rand(0, 59), rand(0, 59)),
		'nationality_id' => rand(1, 2),
		'occupation' => 'test',
		'phone_home' => rand(10000, 90000) . rand(10000, 90000),
		'phone_movil' => rand(10000, 90000) . rand(10000, 90000),
	];
});

$factory->define(App\Models\Permisologia\Role::class, function (Faker $faker) {
	$rol = $faker->numerify('Rol ####');
	return [
		'name' => $rol,
		'slug' => $rol,
		'description' => 'Rol de prueba',
		'from_at' => \Carbon\Carbon::parse('08:00:00'),
		'to_at' => \Carbon\Carbon::parse('17:00:00'),
	];
});

$factory->define(App\Models\Course::class, function (Faker $faker) {
	$teachers = \App\Models\Permisologia\Role::where('slug', '=', 'profesor')->first()->users()->pluck('id');
	$total_teachers = $teachers->count();
	$coordinators = \App\Models\Permisologia\Role::where('slug', '=', 'coordinador')->first()->users()->pluck('id');
	$total_coordinators = $coordinators->count();
	return [
		'coursestate_id' => rand(1, 2),
		'code' => $faker->numerify('#####################'),
		'coordinator_id' => $coordinators[rand(0, $total_coordinators-1)],
		'idioma_id' => rand(1, 4),
		'teacher_id' => $teachers[rand(0, $total_teachers-1)],
		'user_id' => 1,
		'type_student_id' => rand(1, 5),
		'level_id' => rand(1, 6),
		'class_type_id' => rand(1, 2),
        'material_id' => rand(1, 6),
        'company_id' => rand(1, 10)
	];
});

$factory->define(App\Models\Company::class, function (Faker $faker) {
	$name = $faker->numerify('Empresa ####');
	$emails = [
		'@gmail.com', '@hotmail.com',
		'@mail.com', '@outlook.com',
		'@yahoo.com', '@smoothtalkers.com'
	];
	$name_c = $faker->firstName;
	return [
		'name' => $name,
		'rut' => $faker->numerify('#########'),
		'email' => $name . $emails[rand(0, 5)],
		'phone' => $faker->numerify('#########'),
		'name_c' => $name_c,
		'email_c' => $name_c . $emails[rand(0, 5)],
		'phone_c' => $faker->numerify('#########'),
	];
});
