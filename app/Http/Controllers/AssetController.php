<?php

namespace App\Http\Controllers;

use App\asset;
use App\AssetModel;
use App\Brand;
use App\Category;
use App\CostCenter;
use App\Exports\AssetsExport;
use App\Imports\BrandsImport;
use App\Status;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('asset.view')) {

            $search = $request->input('search');
            $categories = Category::all();
            $locations = Location::all();
            $statuses = Status::all();
            $brands = Brand::all();
            $assetModels = AssetModel::all();
            $costCenters = CostCenter::all();
            $assets = Asset::search($search)->paginate(7);
            return view('assets.index', compact('assets', 'search', 'categories', 'locations', 'statuses', 'brands', 'assetModels', 'costCenters'));

        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('asset.create')) {
            $this->validate($request, [
                'asset_code' => 'required|unique:assets',
                'asset_it_code' => 'required|unique:assets',
                'asset_description' => 'required',
                'asset_brand' => 'required',
                'asset_model' => 'required',
                'asset_category' => 'required',
                'asset_serial' => 'required',
                'asset_qty' => 'required',
                'asset_unit' => 'required',
                'asset_costcenter' => 'required',
                'asset_location' => 'required',
                'asset_status' => 'required',
                'asset_remark' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',

            ],
                [
                    'asset_name.required' => 'team tea',
                    'asset_code.unique' => 'asset code mean hx',
                    'asset_code.required' => 'team tea',
                ]);

            $asset = new Asset();
            $asset->asset_code = $request->asset_code;
            $asset->asset_it_code = $request->asset_it_code;
            $asset->asset_name = $request->asset_description;
            $asset->asset_serial = $request->asset_serial;
            $asset->asset_qty = $request->asset_qty;
            $asset->asset_unit = $request->asset_unit;
            $asset->asset_image = 'default.png';
            $asset->asset_remark = $request->asset_remark;
            $asset->user_id = Auth::user()->id;
            $asset->brand_id = $request->asset_brand;
            $asset->model_id = $request->asset_model;
            $asset->category_id = $request->asset_category;
            $asset->status_id = $request->asset_status;
            $asset->costcenter_id = $request->asset_costcenter;
            $asset->location_id = $request->asset_location;

            // get form image
            $image = $request->file('image');
            if (isset($image)) {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $request->asset_code . '-' . $currentDate . '.' . $image->getClientOriginalExtension();
                /*check labor dir is exists*/
                if (!Storage::disk('public')->exists('assets')) {
                    Storage::disk('public')->makeDirectory('assets');
                }
                /*resize image for labor and upload*/
                $labors = Image::make($image)->resize(472, 709)->save();
                Storage::disk('public')->put('assets/' . $imageName, $labors);

            } else {
                $imageName = 'default.png';
            }

            $asset->asset_image = $imageName;
            $asset->save();

            $notification = [
                'message' => 'The asset Add successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('assets.index')->with($notification);

        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (Auth::user()->can('asset.update')) {
            $categories = Category::all();
            $locations = Location::all();
            $statuses = Status::all();
            $brands = Brand::all();
            $assetModels = AssetModel::all();
            $costCenters = CostCenter::all();
            $asset = asset::find($id);
            return view('assets.edit', compact('asset','categories','locations','statuses','brands','assetModels','costCenters'));
        } else {
            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('asset.update')) {
            $this->validate($request, [
                'asset_code' => 'required|unique:assets,asset_code,'.$id,
                'asset_it_code' => 'required|unique:assets,asset_it_code,'.$id,
                'asset_description' => 'required',
                'asset_brand' => 'required',
                'asset_model' => 'required',
                'asset_category' => 'required',
                'asset_serial' => 'required',
                'asset_qty' => 'required',
                'asset_unit' => 'required',
                'asset_costcenter' => 'required',
                'asset_location' => 'required',
                'asset_status' => 'required',
                'asset_remark' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',

            ],
                [
                    'asset_name.required' => 'team tea',
                    'asset_code.unique' => 'asset code mean hx',
                    'asset_code.required' => 'team tea',
                ]);

            $asset = Asset::find($id);
            $asset->asset_code = $request->asset_code;
            $asset->asset_it_code = $request->asset_it_code;
            $asset->asset_name = $request->asset_description;
            $asset->asset_serial = $request->asset_serial;
            $asset->asset_qty = $request->asset_qty;
            $asset->asset_unit = $request->asset_unit;
            $asset->asset_remark = $request->asset_remark;
            $asset->user_id = Auth::user()->id;
            $asset->brand_id = $request->asset_brand;
            $asset->model_id = $request->asset_model;
            $asset->category_id = $request->asset_category;
            $asset->status_id = $request->asset_status;
            $asset->costcenter_id = $request->asset_costcenter;
            $asset->location_id = $request->asset_location;

            // get form image
            $image = $request->file('image');
            if (isset($image)) {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $request->asset_code . '-' . $currentDate . '.' . $image->getClientOriginalExtension();
                /*check labor dir is exists*/
                if (!Storage::disk('public')->exists('assets')) {
                    Storage::disk('public')->makeDirectory('assets');
                }
                //delete old image
                if (Storage::disk('public')->exists('assets/default.png')) {

                }else{
                    Storage::disk('public')->exists('assets/' . $asset->asset_image);
                    Storage::disk('public')->delete('assets/' . $asset->asset_image);
                }

                /*resize image for labor and upload*/
                $labors = Image::make($image)->resize(472, 709)->save();
                Storage::disk('public')->put('assets/' . $imageName, $labors);

            } else {
                $imageName = $asset->asset_image;
            }

            $asset->asset_image = $imageName;
            $asset->update();

            $notification = [
                'message' => 'The asset Update successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('assets.index')->with($notification);

        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (Auth::user()->can('asset.delete')) {
                $asset = Asset::where('id', $id)->delete();

                if (!Storage::disk('public')->exists('assets/default.png')) {
                    Storage::disk('public')->exists('assets/' . $asset->asset_image);
                    Storage::disk('public')->delete('assets/' . $asset->asset_image);
                }

                $notification = [
                    'message' => 'The asset Delete successfully!',
                    'alert-type' => 'success'
                ];

                return redirect()->back()->with($notification);
            } else {
                $notification = [
                    'message' => __('words.not_permission'),
                    'alert-type' => 'warning'
                ];

                return redirect()->back()->with($notification);
            }
        }catch (QueryException $e){

            $notification = [
                'message' => 'Can\'t delete now!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }

    }
    public function exportAsset()
    {
         $asset = Excel::download(new AssetsExport, 'Asset.xlsx');

        $notification = [
            'message' => 'Export successfully',
            'alert-type' => 'success'
        ];

         redirect()->back()->with($notification);
        return $asset;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        try {
            $request->validate([
                'file_excel' => 'required|mimes:csv,xlsx,xls|max:50000'
            ],
                [
                    'file_excel.required' => 'Required file',
                    'file_excel.mimes' => 'File type allow is csv,xlsx, xls',
                    'file_excel.max' => 'Maximum file is 50MB'
                ]);

            if ($request->hasFile('file_excel')) {
                Excel::import(new BrandsImport, $request->file_excel);

                $notification = [
                    'message' => 'Import Brand successfully!',
                    'alert-type' => 'success'
                ];

                return redirect()->route('brands.index')->with($notification);
            }
        } catch (QueryException $e) {

            $notification = [
                'message' => 'Maybe error field of table, Please check it and try again!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function viewDetail($id)
    {
        $assets = DB::table('assets')
            ->join('brands','brands.id','=','assets.brand_id')
            ->join('asset_models','asset_models.id','=','assets.model_id')
            ->join('categories','categories.id','=','assets.category_id')
            ->join('statuses','statuses.id','=','assets.status_id')
            ->join('locations','locations.id','=','assets.location_id')
            ->join('cost_centers','cost_centers.id','=','assets.costcenter_id')
            ->join('users','users.id','=','assets.user_id')
            ->select('brands.brand_name AS brandName','asset_models.model_name AS modelName'
                ,'categories.category_name AS categoryName','statuses.status_name AS statusName'
                ,'locations.location_name AS locationName'
                ,'cost_centers.costcenter_name AS costcenterName','users.name AS user_name','assets.*')
            ->where('assets.id',$id)
            ->get();
        return view('assets.view',compact('assets'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view_report_active(Request $request)
    {
        $search = $request->input('search');
        $assets = Asset::search($search)->where('status_id','1')->paginate(7);

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
                'categories' => [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
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

        return view('manage-reports.assets.active',compact('assets','search','chart1'));
    }
}
