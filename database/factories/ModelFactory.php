<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->name,
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'gender' => $faker->numberBetween(0,1),
        'password' => $password ?: $password = bcrypt('secret'),
        'date_of_birth' => $faker->date,
        'avatar' => str_random(10),
        'cv' => str_random(10),
        'language' => str_random(2),
        'country' => str_random(2),
        'role' => str_random(2),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Lesson::class, function (Faker\Generator $faker) {
    return [
        'course_id' => $faker->numberBetween(1, 100),
        'lessonNo' => $faker->numberBetween(1, 100),
        'lesson_name' => $faker->sentence,
        'description' => $faker->sentences(2,true),
        'author' => str_random(2,true),
        'added_by' => 1,
        'last_updated_by' => 1,
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Course::class, function (Faker\Generator $faker) {
    return [
        'thumbnail' => str_random(10, true),
        'name' => str_random(10, true),
        'description' => $faker->sentences(3, true),
        'age' => $faker->numberBetween(1, 100),
        'author' => str_random(10, true),
        'added_by' => 1,
        'last_updated_by' => 1,
    ];
});
