<?php

namespace App\Http\Controllers;

use App\Exports\RolesExport;
use App\Permission;
use App\Role;
use App\RoleUser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RoleController extends Controller
{

    /*public function __construct()
    {
        $this->middleware('can:role.view',   ['only' => ['index','show']]);
        $this->middleware('can:role.create', ['only' => ['create','store']]);
        $this->middleware('can:role.update', ['only' => ['edit','update']]);
        $this->middleware('can:role.delete', ['only' => ['destroy']]);
    }*/


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        if (Auth::user()->can('role.view')) {

            $search = $request->input('search');
            $roles = Role::search($search)->paginate(7);

            return view('roles.index', compact('roles', 'search'));

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (Auth::user()->can('role.create')) {

            $permissions = Permission::all();
            return view('roles.create', compact('permissions'));

        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('role.create')) {
            $this->validate($request, [
                'name' => 'required|unique:roles',

            ],
                [
                    'name.unique' => 'mean hx',
                    'name.required' => 'team tea',
                ]);

            $role = Role::create([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);
            $role->permissions()->sync($request->input('permission'));

            $notification = [
                'message' => 'The Role Add successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('role.index')->with($notification);
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (Auth::user()->can('role.update')) {
            $role = Role::find($id);
            $permissions = Permission::all();
            return view('roles.edit', compact('role', 'permissions'));
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('role.update')) {
            $current_user_logged = Auth::user()->id;
            if ($current_user_logged == $id) {
                ;
                $notification = [
                    'message' => 'Can\'t update role by itself!',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->with($notification);
            } else {
                $this->validate($request, [
                    'name' => 'required'
                ]);
                $role = Role::find($id);
                $role->name = $request->name;
                $role->description = $request->description;
                $role->save();
                $role->permissions()->sync($request->input('permission'));

                $notification = [
                    'message' => 'The Role Update successfully!',
                    'alert-type' => 'success'
                ];

                return redirect(route('role.index'))->with($notification);
            }
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            if (Auth::user()->can('role.delete')) {
                $current_user_logged = Auth::user()->id;
                if ($current_user_logged == $id) {
                    ;
                    $notification = [
                        'message' => 'Can\'t delete current user logged now!',
                        'alert-type' => 'error'
                    ];

                    return redirect()->back()->with($notification);
                } else {
                    Role::where('id', $id)->delete();

                    $notification = [
                        'message' => 'The Role Delete successfully!',
                        'alert-type' => 'success'
                    ];

                    return redirect()->back()->with($notification);
                }

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

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function user($id)
    {
        if (Auth::user()->can('role.view')) {
            $role = Role::find($id);

            $roleUsers = DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->select('users.*')
                ->where('role_id', $id)
                ->get();

            return view('roles.user', compact('role', 'roleUsers'));
        } else {
            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function export()
    {
        return Excel::download(new RolesExport, 'Role and Permission.xlsx');
    }
}
