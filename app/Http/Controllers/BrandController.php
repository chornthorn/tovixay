<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Exports\BrandsExport;
use App\Imports\BrandsImport;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('brand.view')) {

            $search = $request->input('search');
            $brands = Brand::search($search)->paginate(10);
            return view('brands.index', compact('brands', 'search'));

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
        if (Auth::user()->can('brand.create')) {
            $this->validate($request, [
                'brand_code' => 'required|unique:brands',
                'brand_name' => 'required',

            ],
                [
                    'brand_name.required' => 'team tea',
                    'brand_code.unique' => 'brand code mean hx',
                    'brand_code.required' => 'team tea',
                ]);

            Brand::create([
                'brand_code' => $request->input('brand_code'),
                'brand_name' => $request->input('brand_name'),
                'brand_status' => '1',
                'user_id' => Auth::user()->id,
            ]);

            $notification = [
                'message' => 'The Brand Add successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('brands.index')->with($notification);

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
        if (Auth::user()->can('brand.update')) {
            $brand = Brand::find($id);
            return view('brands.edit', compact('brand'));
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
        if (Auth::user()->can('brand.update')) {
            $this->validate($request, [
                'brand_code' => 'required|unique:brands,brand_code,' . $id,
                'brand_name' => 'required',
            ]);
            $brand = Brand::find($id);
            $brand->brand_code = $request->brand_code;
            $brand->brand_name = $request->brand_name;
            $brand->user_id = Auth::user()->id;
            $brand->brand_status = $request->brand_status;
            $brand->save();

            $notification = [
                'message' => 'The Brand Update successfully!',
                'alert-type' => 'success'
            ];

            return redirect(route('brands.index'))->with($notification);
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
            if (Auth::user()->can('brand.delete')) {
                Brand::where('id', $id)->delete();

                $notification = [
                    'message' => 'The Brand Delete successfully!',
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

    public function exportBrand()
    {
        try {
            return Excel::download(new BrandsExport, 'Brands.xlsx');

        } catch (QueryException $e) {
            $notification = [
                'message' => 'You are can\'t export it! Now!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
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
}
