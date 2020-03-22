<?php

use App\Asset;
use App\AssetModel;
use App\Brand;
use App\Category;
use App\Computer;
use App\CostCenter;
use App\Location;
use App\Status;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(StatusSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS = 0 ');
//        User::truncate();
        Category::truncate();
        Brand::truncate();
        AssetModel::truncate();
        Location::truncate();
        CostCenter::truncate();
//        Status::truncate();
        Asset::truncate();
        Computer::truncate();

        $usersQuantity = 5;
        $categoryQuantity = 1;
        $brandQuantity = 30;
        $modelQuantity = 30;
        $locationQuantity = 30;
        $costCenterQuantity = 30;
        $statusQuantity = 4;
        $assetQuantity = 50;
        $computerQuantity = 5;

//        factory(User::class,$usersQuantity)->create();

        factory(Category::class, $categoryQuantity)->create();
        factory(Brand::class, $brandQuantity)->create();
        factory(AssetModel::class, $modelQuantity)->create();
        factory(Location::class, $locationQuantity)->create();
        factory(CostCenter::class, $costCenterQuantity)->create();
//        factory(Status::class, $statusQuantity)->create();
        factory(Asset::class, $assetQuantity)->create();
        factory(Computer::class, $computerQuantity)->create();
    }
}
