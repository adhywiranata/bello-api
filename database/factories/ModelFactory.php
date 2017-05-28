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

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(App\Buyrequest::class, function ($faker) {
    $randomDateTime = $faker->dateTimeBetween($startDate='-4 month 28 days',$endDate='now')->format('Y-m-d H:i:s');
    $exportDays     = 14;
    $reminder       = date("Y-m-d", strtotime($randomDateTime . "+" . $exportDays . " days"));
    return [
        'user_id'                 => $faker->randomElement($array = array ('2886652','1979833','2166751','9500417','31040836')),
        'keyword'                 => "gundam",
        'is_purchase'             => 0,
        'reminder_schedule'       => $reminder,
        'is_read'                 => 0,
        'is_delete'               => 0,
        'created_at'              => $randomDateTime,
        'updated_at'              => $randomDateTime,
    ];
});
