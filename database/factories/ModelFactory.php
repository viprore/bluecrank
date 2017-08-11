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


$factory->define(App\User::class, function () {
    $faker = Faker\Factory::create('ko_KR');
    static $password;
    $activated = $faker->randomElement([0, 1]);
    $isSeller = $faker->randomElement([true, false]);

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $isSeller ? $faker->phoneNumber : null,
        'password' => $password ?: $password = bcrypt('secrets'),
        'remember_token' => str_random(10),
        'activated' => $activated,
        'confirm_code' => $activated ? null : str_random(60),
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    $date = $faker->dateTimeThisMonth;
    $userId = App\User::pluck('id')->toArray();

    return [
        'title' => $faker->sentence(),
        'content' => $faker->paragraph(),
        'user_id' => $faker->randomElement($userId),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

$factory->define(App\Attachment::class, function (Faker\Generator $faker) {
    return [
        'filename' => sprintf("%s.%s",
            str_random(),
            $faker->randomElement(config('project.mimes'))
        )
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    $userIds = App\User::pluck('id')->toArray();

    return [
        'content' => $faker->paragraph,
        'user_id' => function () use ($faker, $userIds) {
            return $faker->randomElement($userIds);
        },
    ];
});

$factory->define(App\Vote::class, function (Faker\Generator $faker) {
    $up = $faker->randomElement([true, false]);
    $down = !$up;
    $userIds = App\User::pluck('id')->toArray();

    return [
        'up' => $up ? 1 : null,
        'down' => $down ? 1 : null,
        'user_id' => function () use ($faker, $userIds) {
            return $faker->randomElement($userIds);
        },
    ];
});


$factory->define(App\Product::class, function () {
    $faker = Faker\Factory::create('ko_KR');
    $date = $faker->dateTimeThisMonth;

    return [
        'category' => $faker->randomElement([
            'road', 'mtb', 'fixed', 'hybrid', 'mini',
            'bacc', 'racc', 'part'
        ]),
        'ad_title' => $faker->realText(20),
        'ad_status' => $faker->randomElement(['준비중', '판매', '매진']),
        'ad_short_description' => $faker->sentence(6),
        'price' => $faker->numberBetween(0, 1000) * 10000,
        'description' => $faker->realText(500),
        'created_at' => $faker->dateTimeBetween('-1 month', $date),
        'updated_at' => $date,
        'is_old' => $faker->randomElement([true, false]),
    ];
});

$factory->define(App\Option::class, function (Faker\Generator $faker) {
    return [
        'size' => $faker->randomElement(['XS', 'S', 'M', 'L', 'XL', '460', '480', '500', '520', '540',]),
        'color' => $faker->colorName,
        'inventory' => 999,
        'etc' => $faker->realText(20),
    ];
});

$factory->define(App\Review::class, function () {
    $faker = Faker\Factory::create('ko_KR');
    $userId = App\User::pluck('id')->toArray();
    $productId = App\Product::pluck('id')->toArray();
    $date = $faker->dateTimeThisMonth;
    return [
        'user_id' => $faker->randomElement($userId),
        'product_id' => $faker->randomElement($productId),
        'rating' => $faker->numberBetween(0, 5),
        'title' => $faker->realText(20),
        'content' => $faker->realText(500),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

$factory->define(App\Ship::class, function () {
    $faker = Faker\Factory::create('ko_KR');

    $alias = [
        '회사', '집', '가게', '친구집'
    ];
    return [
        'alias' => $faker->randomElement($alias),
        'name' => $faker->name,
        'postcode' => $faker->postcode,
        'find_address' => $faker->address,
        'input_address' => $faker->streetName . " " . $faker->company,
        'contact' => $faker->phoneNumber,
    ];
});

$factory->define(App\Order::class, function () {
    $faker = Faker\Factory::create('ko_KR');
    $request = [
        '빠른 시일 내로 배송 부탁드립니다.',
        '부서지기 쉬우니 안전배송 부탁드려요',
        '올때 연락 주세요',
        '부재시 연락 주세요',
        '울면서 건네주세요.'
    ];

    return [
        'name' => $faker->name,
        'postcode' => $faker->postcode,
        'find_address' => $faker->address,
        'input_address' => $faker->streetName . " " . $faker->company,
        'contact' => $faker->phoneNumber,
        'please' => $faker->randomElement($request),
        'paymethod' => $faker->randomElement(['계좌이체', '무통장입금', '신용카드']),
        'amount' => $faker->numberBetween(0, 1000) * 10000
    ];
});

$factory->define(App\Item::class, function (Faker\Generator $faker) {
    $optionId = App\Option::pluck('id')->toArray();
    return [
        'option_id' => $faker->randomElement($optionId),
        'count' => $faker->numberBetween(1, 5),
    ];
});
