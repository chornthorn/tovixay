<?php

use App\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::find('1');


        Status::create(['status_name' => 'Avairiable','status_code' => '1010','status_status'=>'1','user_id'=>$user->id]);
        Status::create(['status_name' => 'Unavairiable','status_code' => '1011','status_status'=>'1','user_id'=>$user->id]);
        Status::create(['status_name' => 'Pending','status_code' => '1012','status_status'=>'1','user_id'=>$user->id]);
        Status::create(['status_name' => 'Lost','status_code' => '1013','status_status'=>'1','user_id'=>$user->id]);
//        Status::create(['status_name' => 'Good','status_code' => '2322','status_status'=>'1','user_id'=>$user->id]);
    }
}
