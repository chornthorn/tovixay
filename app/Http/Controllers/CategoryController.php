<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\CategoriesExport;
use App\Imports\CategoriesImport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('category.view')) {

            $search = $request->input('search');
            $categories = Category::search($search)->paginate(10);
            return view('categories.index', compact('categories', 'search'));

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
     * @throws \Exception
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('category.create')) {
            $this->validate($request, [
                'category_name' => 'required|unique:categories',

            ],
                [
                    'category_name.required' => 'team tea',
                ]);
            $category_code = IdGenerator::generate(['table' => 'categories','field'=>'id', 'length' => 8, 'prefix' =>'CT-']);
            Category::create([
                'id' => $category_code,
                'category_name' => $request->input('category_name'),
                'category_status' => '1',
                'user_id' => Auth::user()->id,
            ]);

            $notification = [
                'message' => 'The Category Add successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('categories.index')->with($notification);

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
        if (Auth::user()->can('category.update')) {
            $category = Category::find($id);
            return view('categories.edit', compact('category'));
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
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('category.update')) {

            $this->validate($request, [
                'category_name' => 'required|unique:categories,category_name,'.$id,
            ]);
            $category = Category::find($id);
            $category->category_name = $request->category_name;
            $category->user_id = Auth::user()->id;
            $category->category_status = $request->category_status;
            $category->update();

            $notification = [
                'message' => 'The Category Update successfully!',
                'alert-type' => 'success'
            ];

            return redirect(route('categories.index'))->with($notification);
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
            if (Auth::user()->can('category.delete')) {
                Category::where('id', $id)->delete();

                $notification = [
                    'message' => 'The Category Delete successfully!',
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
                'message' => 'You are can\'t delete this Category!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);

        }
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        Category::whereIn('id', explode("," . $ids))->delete();
        return redirect()->route('categories.index');
    }

    public function exportCategory()
    {
        try {
            return Excel::download(new CategoriesExport, 'category.xlsx');
        } catch (QueryException $e) {

            $notification = [
                'message' => 'Oop! You are can\'t Export right now!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'category_file' => 'required|mimes:csv,xlsx,xls|max:50000'
            ],
                [
                    'category_file.required' => 'Required category file',
                    'category_file.mimes' => 'File type allow is csv,xlsx, xls',
                    'category_file.max' => 'Maximum file is 50MB'
                ]);

            if ($request->hasFile('category_file')) {
                Excel::import(new CategoriesImport, $request->category_file);

                $notification = [
                    'message' => 'Import Category successfully!',
                    'alert-type' => 'success'
                ];

                return redirect()->route('categories.index')->with($notification);
            }
        } catch (QueryException $e) {

            $notification = [
                'message' => 'Maybe error field of table, Please check it and try again!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function pdf()
    {
        $data = Category::all();
        $pdf = PDF::loadView('pdf.category',compact('data'))->setPaper('a4','portrait');

        return $pdf->stream('thorn'.'.pdf');
    }
}
