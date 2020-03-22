<?php

namespace App\Http\Controllers;

use App\AssetModel;
use App\Exports\AssetModelsExport;
use App\Imports\ModelsImport;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('model.view')) {

            $search = $request->input('search');
            $models = AssetModel::search($search)->paginate(10);
            return view('models.index', compact('models', 'search'));

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
        if (Auth::user()->can('model.create')) {
            $this->validate($request, [
                'model_code' => 'required|unique:asset_models',
                'model_name' => 'required',

            ],
                [
                    'model_name.required' => 'team tea',
                    'model_code.unique' => 'model code mean hx',
                    'model_code.required' => 'team tea',
                ]);

            AssetModel::create([
                'model_code' => $request->input('model_code'),
                'model_name' => $request->input('model_name'),
                'model_status' => '1',
                'user_id' => Auth::user()->id,
            ]);

            $notification = [
                'message' => 'The model Add successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('models.index')->with($notification);

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
        if (Auth::user()->can('model.update')) {
            $model = AssetModel::find($id);
            return view('models.edit', compact('model'));
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
        if (Auth::user()->can('model.update')) {
            $this->validate($request, [
                'model_code' => 'required|unique:asset_models,model_code,' . $id,
                'model_name' => 'required',
            ]);
            $model = AssetModel::find($id);
            $model->model_code = $request->model_code;
            $model->model_name = $request->model_name;
            $model->user_id = Auth::user()->id;
            $model->model_status = $request->model_status;
            $model->save();

            $notification = [
                'message' => 'The model Update successfully!',
                'alert-type' => 'success'
            ];

            return redirect(route('models.index'))->with($notification);
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
            if (Auth::user()->can('model.delete')) {
                AssetModel::where('id', $id)->delete();

                $notification = [
                    'message' => 'The model Delete successfully!',
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
        return Excel::download(new AssetModelsExport, 'Models.xlsx');
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
                Excel::import(new ModelsImport, $request->file_excel);

                $notification = [
                    'message' => 'Import Model successfully!',
                    'alert-type' => 'success'
                ];

                return redirect()->route('models.index')->with($notification);
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
