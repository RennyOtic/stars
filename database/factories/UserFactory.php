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
	$course = $faker->numerify('Curso #######');
	$classType = rand(1, 2);
	$max_students = ($classType > 1) ? 1 : rand(10, 20);
	$hour_start = \Carbon::parse(20 . ':' . rand(0, 59));
	$total_teachers = \App\Models\Permisologia\Role::where('slug', '=', 'Profesor')
	->findOrFail(2)->users()->count();
	$teachers = \App\Models\Permisologia\Role::where('slug', '=', 'Profesor')
	->findOrFail(2)->users()->pluck('id');
	return [
		'name' => $course,
		'slug' => $course,
		'code' => $faker->numerify('#####################'),
		'hour_start' => $hour_start->format('H:i'),
		'hour_end' => $hour_start->addHours(2)->format('H:i'),
		'idioma_id' => rand(1, 4),
		'teacher_id' => $teachers[rand(0, $total_teachers-1)],
		'user_id' => 1,
		'max_students' => $max_students,
		'max_class' => rand(10, 20),
		'type_student_id' => rand(1, 5),
		'level_id' => rand(1, 6),
		'class_type_id' => $classType,
		'date_inscription_start_at' => \Carbon::now()->subWeeks(rand(0, 3))->subDays(rand(1, 5))->format('Y-m-d'),
		'date_inscription_end_at' => \Carbon::now()->addWeeks(1)->addDays(rand(1, 5))->format('Y-m-d'),
		'date_start_at' => \Carbon::now()->subWeeks(rand(0, 2))->subDays(1)->format('Y-m-d'),
		'date_end_at' => \Carbon::now()->addWeeks(rand(1, 3))->addDays(rand(1, 5))->format('Y-m-d'),
	];
});
