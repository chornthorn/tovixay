<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('user.view')) {

            $search = $request->input('search');
            $users = User::search($search)->paginate(7);
            return view('users.index', compact('users', 'search'));

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        if (Auth::user()->can('user.create')) {

            $roles = Role::all();
            return view('users.create', compact('roles'));

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('user.create')) {

            $this->validate($request, [
                'name' => 'required|max:50',
                'email' => 'required|email|unique:users|max:255',
                'role' => 'required'

            ]);
            /*$user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt('12345678')
            ]);*/

            $random = 12345678;
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($random);

            $user->save();

            $user->roles()->sync($request->input('role'));

            $notification = [
                'message' => 'The User Add successfully!',
                'alert-type' => 'success'
            ];

            /*$email = $request->email;
            $pass = bcrypt('12345678');
            $messageData = ['email' => $request->email, 'name' => $request->name, 'code' => $random];

            Mail::send('mails.send_code', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Send password to user');
            });*/

            return redirect()->route('user.index')->with($notification);

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->can('user.show')) {


        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (Auth::user()->can('user.update')) {

            $roles = Role::all();
            $user = User::find($id);
            return view('users.edit', compact('roles', 'user'));

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
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('user.update')) {
            $current_user_logged = Auth::user()->id;
            $is_superAdmin = 1;
            if ($current_user_logged == $id) {
                ;
                $notification = [
                    'message' => 'Can\'t update current user logged now!',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->with($notification);
            } elseif ($is_superAdmin == $id) {
                $notification = [
                    'message' => 'Can\'t update super Administration!',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->with($notification);
            } else {

                $this->validate($request, [
                    'name' => 'required|max:50',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'role' => 'required'

                ]);

                $user = User::find($id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = '12345678';
                $user->save();

                $user->roles()->sync($request->input('role'));

                $notification = [
                    'message' => 'The User Update successfully!',
                    'alert-type' => 'success'
                ];
                return redirect()->route('user.index')->with($notification);
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (Auth::user()->can('user.delete')) {
                $current_user_logged = Auth::user()->id;
                $is_superAdmin = 1;
                if ($current_user_logged == $id) {
                    ;
                    $notification = [
                        'message' => 'Can\'t delete current user logged now!',
                        'alert-type' => 'error'
                    ];

                    return redirect()->back()->with($notification);
                } elseif ($is_superAdmin == $id) {

                    $notification = [
                        'message' => 'Can\'t delete super Administration!',
                        'alert-type' => 'error'
                    ];

                    return redirect()->back()->with($notification);
                } else {

                    $user = User::find($id);
                    $user->delete();
                    $notification = [
                        'message' => 'The User Delete successfully!',
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

    public function profile(Request $request, $id)
    {
        if (Auth::user()->id != $id) {

            $notification = [
                'message' => 'You can\'t access to another profile!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);

        } else {

            $user_profile = DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.name', 'users.email','users.about', 'users.created_at', 'users.updated_at',
                    'roles.id', 'roles.name AS role_name', 'roles.description')
                ->where('users.id', $id)->get();

            return view('users.profile', compact('user_profile'));
        }
    }

    public function updateAbout(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'about' => 'required|string',
        ],
        [
            'name.required' => 'Name field is required',
            'about.required' => 'About field is required',
            'about.string' => 'About field is required about string',
        ]);
        $user = User::find(Auth::user()->id);
        $user->about = $request->about;
        $user->name = $request->name;
        $user->update();

        $notification = [
            'message' => 'Update profile successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|same:password',
            'password_confirmation' => 'required|same:password',
            'current_password' => 'required'
        ],
            [
                'password.required' => 'Password field is required',
                'password_confirmation.required' => 'Password confirmation field is required',
                'password_confirmation.same' => 'Field should be same as New Password',
                'current_password.required' => 'Current password field is required'
            ]);

        if (Auth::Check()) {
            if (Hash::check($request->current_password, Auth::User()->password)) {
                User::find(Auth::user()->id)->update(["password" => bcrypt($request->password)]);
            } else {
                $notification = [
                    'message' => 'Incorrect Details !',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->with($notification);
            }
        }

        $notification = [
            'message' => 'Password changed successfully !',
            'alert-type' => 'success'
        ];

        return redirect()->route('user.index')->with($notification);
    }

}
