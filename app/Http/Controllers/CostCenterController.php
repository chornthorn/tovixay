<?php

namespace App\Http\Controllers;

use App\costcenter;
use App\Exports\CostCentersExport;
use App\Imports\CostCentersImport;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('costcenter.view')) {

            $search = $request->input('search');
            $costcenters = CostCenter::search($search)->paginate(10);
            return view('costcenters.index', compact('costcenters', 'search'));

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
        if (Auth::user()->can('costcenter.create')) {
            $this->validate($request, [
                'costcenter_code' => 'required|unique:cost_centers',
                'costcenter_name' => 'required',

            ],
                [
                    'costcenter_name.required' => 'team tea',
                    'costcenter_code.unique' => 'costcenter code mean hx',
                    'costcenter_code.required' => 'team tea',
                ]);

            CostCenter::create([
                'costcenter_code' => $request->input('costcenter_code'),
                'costcenter_name' => $request->input('costcenter_name'),
                'costcenter_status' => '1',
                'user_id' => Auth::user()->id,
            ]);

            $notification = [
                'message' => 'The costcenter Add successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('costcenters.index')->with($notification);

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
        if (Auth::user()->can('costcenter.update')) {
            $costcenter = CostCenter::find($id);
            return view('costcenters.edit', compact('costcenter'));
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
        if (Auth::user()->can('costcenter.update')) {
            $this->validate($request, [
                'costcenter_code' => 'required|unique:cost_centers,costcenter_code,' . $id,
                'costcenter_name' => 'required',
            ]);
            $costcenter = CostCenter::find($id);
            $costcenter->costcenter_code = $request->costcenter_code;
            $costcenter->costcenter_name = $request->costcenter_name;
            $costcenter->user_id = Auth::user()->id;
            $costcenter->costcenter_status = $request->costcenter_status;
            $costcenter->save();

            $notification = [
                'message' => 'The costcenter Update successfully!',
                'alert-type' => 'success'
            ];

            return redirect(route('costcenters.index'))->with($notification);
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
            if (Auth::user()->can('costcenter.delete')) {
                CostCenter::where('id', $id)->delete();

                $notification = [
                    'message' => 'The costcenter Delete successfully!',
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
        } catch (QueryException $e) {
            $notification = [
                'message' => 'You are can\'t delete it! Now!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function export()
    {
        return Excel::download(new CostCentersExport, 'Cost Centers.xlsx');
    }

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
                Excel::import(new CostCentersImport, $request->file_excel);

                $notification = [
                    'message' => 'Import Cost Center successfully!',
                    'alert-type' => 'success'
                ];

                return redirect()->route('costcenters.index')->with($notification);
            }
        } catch (QueryException $e) {

            $notification = [
                'message' => 'Maybe error field of table, Please check it and try again!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }
}
