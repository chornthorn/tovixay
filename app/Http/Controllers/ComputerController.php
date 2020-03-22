<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Computer;
use App\Exports\ComputersExport;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $assets = Asset::categories('CT-00001')->get();

        $computers = DB::table('computers')
            ->join('assets','assets.id','=','computers.asset_id')
            ->join('brands','brands.id','=','assets.brand_id')
            ->join('asset_models','asset_models.id','=','assets.model_id')
            ->join('cost_centers','cost_centers.id','=','assets.costcenter_id')
            ->join('statuses','statuses.id','=','assets.status_id')
            ->join('locations','locations.id','=','assets.location_id')
            ->select('assets.*','computers.*','brands.brand_name AS brandName',
                'asset_models.model_name AS modelName','cost_centers.costcenter_name AS costcenterName',
                'statuses.status_name AS statusName',
                'locations.location_name AS locationName')
            ->where('assets.asset_code', 'like','%' . $search . '%')
            ->orWhere('assets.asset_name', 'like','%' . $search . '%')
            ->orWhere('brands.brand_name', 'like','%' . $search . '%')
            ->orWhere('asset_models.model_name', 'like','%' . $search . '%')
            ->orWhere('cost_centers.costcenter_name', 'like','%' . $search . '%')
            ->orWhere('statuses.status_name', 'like','%' . $search . '%')
            ->orWhere('locations.location_name', 'like','%' . $search . '%')
            ->paginate(10);

        return view('computers.index',compact('computers','search','assets'));
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
        if (Auth::user()->can('computer.create')) {
            $this->validate($request, [
                'asset_id' => 'required|unique:computers',
                'monitor_name' => 'required',
                'mainboard_name' => 'required',
                'cpu' => 'required',
                'hard_disk' => 'required',
                'ram' => 'required',
                'power' => 'required',
                'keyboard' => 'required',
                'mouse' => 'required',
                'cd_rom' => 'required',

            ]);

            $computer = new Computer;
            $computer->asset_id = $request->asset_id;
            $computer->monitor_item = $request->monitor_name;
            $computer->mainboard_item = $request->mainboard_name;
            $computer->cpu_item = $request->cpu;
            $computer->harddisk_item = $request->hard_disk;
            $computer->ram_item = $request->ram;
            $computer->powersupply_item = $request->power;
            $computer->keyboard_item = $request->keyboard;
            $computer->mouse_item = $request->mouse;
            $computer->cdrom_item = $request->cd_rom;
            $computer->user_id = Auth::user()->id;
            $computer->save();


            $notification = [
                'message' => 'The Computer Add successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('computers.index')->with($notification);

        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (Auth::user()->can('computer.update')) {

            $computer = Computer::find($id);
            return view('computers.edit', compact('computer'));

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('computer.update')) {
            $this->validate($request, [
                'monitor_name' => 'required',
                'mainboard_name' => 'required',
                'cpu' => 'required',
                'hard_disk' => 'required',
                'ram' => 'required',
                'power' => 'required',
                'keyboard' => 'required',
                'mouse' => 'required',
                'cd_rom' => 'required',

            ]);

            $computer = Computer::find($id);
            $computer->monitor_item = $request->monitor_name;
            $computer->mainboard_item = $request->mainboard_name;
            $computer->cpu_item = $request->cpu;
            $computer->harddisk_item = $request->hard_disk;
            $computer->ram_item = $request->ram;
            $computer->powersupply_item = $request->power;
            $computer->keyboard_item = $request->keyboard;
            $computer->mouse_item = $request->mouse;
            $computer->cdrom_item = $request->cd_rom;
            $computer->user_id = Auth::user()->id;
            $computer->update();

            $notification = [
                'message' => 'The Computer Update successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('computers.index')->with($notification);

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
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy($id)
    {
        try {
            if (Auth::user()->can('computer.delete')) {

                Computer::where('id', $id)->delete();

                $notification = [
                    'message' => 'The Computer Delete successfully!',
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

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function computerDetail($id)
    {
        if (empty(!$id)){
            $computers = DB::table('computers')
                ->join('assets','assets.id','=','computers.asset_id')
                ->join('brands','brands.id','=','assets.brand_id')
                ->join('asset_models','asset_models.id','=','assets.model_id')
                ->join('categories','categories.id','=','assets.category_id')
                ->join('cost_centers','cost_centers.id','=','assets.costcenter_id')
                ->join('statuses','statuses.id','=','assets.status_id')
                ->join('locations','locations.id','=','assets.location_id')
                ->join('users','users.id','=','computers.user_id')
                ->select('computers.*','assets.*',
                    'brands.brand_name AS brandName',
                    'asset_models.model_name AS modelName',
                    'categories.category_name AS categoryName',
                    'statuses.status_name AS statusName',
                    'cost_centers.costcenter_name AS costcenterName',
                    'locations.location_name AS locationName',
                    'users.name AS userName'
                )->where('computers.id',$id)
                ->get();

            return view('computers.detail',compact('computers'));

        }else{
            return redirect()->back();
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportComputer()
    {
        return Excel::download(new ComputersExport, 'Computer.xlsx');
    }
}
