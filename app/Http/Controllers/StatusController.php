<?php

namespace App\Http\Controllers;

use App\Exports\BrandsExport;
use App\Exports\StatusesExport;
use App\Imports\StatusesImport;
use App\status;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('status.view')) {

            $search = $request->input('search');
            $statuses = Status::search($search)->paginate(10);
            return view('statuses.index', compact('statuses', 'search'));

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
        if (Auth::user()->can('status.create')) {
            $this->validate($request, [
                'status_code' => 'required|unique:statuses',
                'status_name' => 'required',

            ],
                [
                    'status_name.required' => 'team tea',
                    'status_code.unique' => 'status code mean hx',
                    'status_code.required' => 'team tea',
                ]);

            Status::create([
                'status_code' => $request->input('status_code'),
                'status_name' => $request->input('status_name'),
                'status_status' => '1',
                'user_id' => Auth::user()->id,
            ]);

            $notification = [
                'message' => 'The status Add successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('statuses.index')->with($notification);

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
        if (Auth::user()->can('status.update')) {
            $status = Status::find($id);
            return view('statuses.edit', compact('status'));
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
        if (Auth::user()->can('status.update')) {
            $this->validate($request, [
                'status_code' => 'required|unique:statuses,status_code,' . $id,
                'status_name' => 'required',
            ]);
            $status = Status::find($id);
            $status->status_code = $request->status_code;
            $status->status_name = $request->status_name;
            $status->user_id = Auth::user()->id;
            $status->status_status = $request->status_status;
            $status->save();

            $notification = [
                'message' => 'The status Update successfully!',
                'alert-type' => 'success'
            ];

            return redirect(route('statuses.index'))->with($notification);
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
            if (Auth::user()->can('status.delete')) {
                Status::where('id', $id)->delete();

                $notification = [
                    'message' => 'The status Delete successfully!',
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
        return Excel::download(new StatusesExport, 'Statuses.xlsx');
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
                Excel::import(new StatusesImport, $request->file_excel);

                $notification = [
                    'message' => 'Import Status successfully!',
                    'alert-type' => 'success'
                ];

                return redirect()->route('statuses.index')->with($notification);
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
