<?php

namespace App\Http\Controllers;

use App\Asset;
use App\CostCenter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_assets = Asset::all()->count();
        $all_avairiable = Asset::statuses('1')->count();
        $all_unvairiable = Asset::statuses('2')->count();
        $all_pending = Asset::statuses('3')->count();
        $all_lost = Asset::statuses('4')->count();
        $all_users = User::all()->count();
        $all_costcenters = CostCenter::all()->count();

        //
        $status_type = DB::SELECT('SELECT statuses.status_name as status FROM assets INNER JOIN statuses ON assets.status_id = statuses.id GROUP BY statuses.status_name');

        $status_as = [];
        foreach ($status_type as $status_asset) {
            $status_as [] = (array)$status_asset->status;
        }



        //
        $qty_asset = DB::SELECT('SELECT count(assets.id) as countAsset FROM assets INNER JOIN statuses ON assets.status_id = statuses.id GROUP BY statuses.status_name');

        $qty_aa = [];
        foreach ($qty_asset as $status_qty) {
            $qty_aa [] = (array)$status_qty->countAsset;
        }

        // two way
        $data = DB::table("assets")
            ->select( DB::raw("COUNT(assets.id) as countAsset"))
            ->join("statuses","statuses.id","=","assets.status_id")
            ->groupBy("statuses.status_name")
            ->get();

        $qty_tt = [];
        foreach ($data as $a) {
            $qty_tt [] = (array)$a->countAsset;
        }

        $chart1 = \Chart::title([
            'text' => 'Report By Status',
        ])
            ->chart([
                'type' => 'column', // pie , column ect
                'renderTo' => 'chart1', // render the chart into your div with id
            ])
            /*->subtitle([
                'text' => 'This Subtitle',
            ])*/
            ->colors([
                '#0c2959'
            ])
            ->xaxis([
                'categories' => $status_as,
            ])
            ->yaxis([
                'text' => 'This Y Axis',
            ])
            ->series(
                [
                    [
                        'name' => "QTY",
                        'data' => $qty_tt,
//                         'color' => '#000',
                    ],
                ]
            )
            ->display();


        return view('home', compact('all_assets', 'all_avairiable',
            'all_unvairiable', 'all_pending',
            'all_lost', 'all_users', 'all_costcenters', 'chart1'));
    }
}
