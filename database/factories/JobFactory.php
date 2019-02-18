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

$factory->define(App\Job::class, function (Faker $faker) {
    $id     = '~' . $faker->randomAscii;
    $skills = [];

    for ($i = 0; $i <= $faker->randomDigit; $i++) {
        $skills[] = $faker->word;
    }

    return [
        'user_id'      => function () {
            return factory(App\User::class)->create()->id;
        },
        'api_id'       => $id,
        'title'        => $faker->sentence,
        'snippet'      => $faker->sentences(),
        'category2'    => 'Web, Mobile & Software Dev',
        'subcategory2' => $faker->word,
        'skills'       => $skills,
        'job_type'     => $faker->randomElement(['Hourly', 'Fixed']),
        'budget'       => $faker->numberBetween(0, 100000),
        'duration'     => $faker->randomElement([null, 'week', 'month', 'ongoing']),
        'workload'     => $faker->randomElement([null, 'as_needed', 'part_time', 'full_time']),
        'job_status'   => $faker->randomElement(['open', 'completed', 'cancelled']),
        'date_created' => $faker->dateTimeBetween('-1 year'),
        'url'          => "http://www.upwork.com/jobs/{$id}",
        'client'       => [
            'country'                     => 'Singapore',
            'feedback'                    => $faker->numberBetween(0, 5),
            'reviews_count'               => $faker->numberBetween(0, 40),
            'jobs_posted'                 => $faker->numberBetween(0, 40),
            'past_hires'                  => $faker->numberBetween(0, 40),
            'payment_verification_status' => 'VERIFIED',
        ]
    ];
});
