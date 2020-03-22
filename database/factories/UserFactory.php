<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\AssetModel;
use App\Brand;
use App\Category;
use App\Computer;
use App\CostCenter;
use App\Location;
use App\Status;
use App\User;
use Faker\Generator as Faker;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
$factory->define(Category::class, function (Faker $faker) {
    return [
        'id' =>  IdGenerator::generate(['table' => 'categories','field'=>'id', 'length' => 8, 'prefix' =>'CT-']),
        'category_name' => $faker->word,
        'category_status' => $faker->numberBetween(1,1),
        'user_id' =>User::all()->random()->id,
    ];
});

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'brand_code' => $faker->numberBetween(1000,5000),
        'brand_name' => $faker->word,
        'brand_status' => $faker->numberBetween(1,1),
        'user_id' =>User::all()->random()->id,
    ];
});

$factory->define(AssetModel::class, function (Faker $faker) {
    return [
        'model_code' => $faker->numberBetween(1000,5000),
        'model_name' => $faker->word,
        'model_status' => $faker->numberBetween(1,1),
        'user_id' =>User::all()->random()->id,
    ];
});

$factory->define(Location::class, function (Faker $faker) {
    return [
        'location_code' => $faker->numberBetween(1000,5000),
        'location_name' => $faker->word,
        'location_status' => $faker->numberBetween(1,1),
        'user_id' =>User::all()->random()->id,
    ];
});

$factory->define(CostCenter::class, function (Faker $faker) {
    return [
        'costcenter_code' => $faker->numberBetween(1000,5000),
        'costcenter_name' => $faker->word,
        'costcenter_status' => $faker->numberBetween(1,1),
        'user_id' =>User::all()->random()->id,
    ];
});

$factory->define(Status::class, function (Faker $faker) {
    return [
        'status_code' => $faker->numberBetween(1000,5000),
        'status_name' => $faker->randomElement(['Avairiable','Pending','Unavairiable','Lost']),
        'status_status' => $faker->numberBetween(1,1),
        'user_id' =>User::all()->random()->id,
    ];
});

$factory->define(Asset::class, function (Faker $faker) {
    return [
        'asset_code' => $faker->numberBetween(100000,500000),
        'asset_it_code' => $faker->numberBetween(1000000,5000000),
        'asset_name' => $faker->word,
        'asset_serial' => $faker->numberBetween(1,9),
        'asset_qty' => $faker->numberBetween(1,9),
        'asset_unit' => $faker->randomElement(['cm','inch','m']),
        'asset_remark' => $faker->words(1,5),
        'user_id' =>User::all()->random()->id,
        'brand_id' =>Brand::all()->random()->id,
        'model_id' =>AssetModel::all()->random()->id,
        'category_id' =>Category::all()->random()->id,
        'status_id' =>Status::all()->random()->id,
        'costcenter_id' =>CostCenter::all()->random()->id,
        'location_id' =>Location::all()->random()->id,
    ];
});

$factory->define(Computer::class, function (Faker $faker) {
    return [
        'asset_id' =>Asset::all()->random()->id,
//        'asset_id' =>'1',
        'monitor_item' => $faker->word,
        'mainboard_item' => $faker->word,
        'cpu_item' => $faker->numberBetween(500,1000),
        'harddisk_item' => $faker->numberBetween(500,1000),
        'ram_item' => $faker->numberBetween(8,64),
        'powersupply_item' => $faker->numberBetween(8,64),
        'keyboard_item' =>$faker->word,
        'mouse_item' =>$faker->word,
        'cdrom_item' =>$faker->word,
        'computer_status' =>$faker->numberBetween(1,1),
        'user_id' =>User::all()->random()->id,
    ];
});
