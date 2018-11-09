<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\User;
use Session;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function($request, $next){
            if(Gate::allows('manage-users')) return $next($request);

            abort(403, 'Anda tidak memiliki cukup hak akases');
        });
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $filterKeyword = $request->get('keyword');
        $status = $request->get('status');
        if($status){
            $users = User::where('status', $status)->paginate(10);
        } else {
            $users = User::paginate(10);
        }
        if($filterKeyword){
            if($status){
                $users = User::where('email', 'LIKE', "%$filterKeyword%")
                    ->where('status', $status)
                    ->paginate(10);
            } else {
                $users = User::where('email', 'LIKE', "%$filterKeyword%")
                    ->paginate(10);
            }
        }
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate ($request, array(
            'name'=>'required|min:5|max:100',
            'username' =>'required|min:5|max:20|unique:users',
            'roles'=>'required',
            'phone'=>'required|digits_between:10,12',
            'address'=>'required|min:5|max:191',
            'avatar'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'password_confirmation'=>'required|same:password'
        ));

        $new_user = new User;
        $new_user->name = $request->name;
        $new_user->username = $request->username;
        $new_user->roles = json_encode($request->roles);
        $new_user->phone = $request->phone;       
        $new_user->address = $request->address;
        $new_user->email = $request->email;       
        $new_user->password = \Hash::make($request->password);

        if ($request->file('avatar')) {
            $file = $request->file('avatar')->store('avatars', 'public');
            $new_user->avatar = $file;
        }
        $new_user->save();

        Session::flash('success','Data berhasil ditambah');

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'name'=>'required',
            'roles'=>'required',
            'address'=>'required|min:5|max:191',
            'phone'=>'required|digits_between:10,12',
            'status'=>'required'
        ));

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->roles = json_encode($request->input('roles'));
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->status = $request->input('status');

        if($request->file('avatar')){
            if($user->avatar && file_exists(storage_path('app/public'.$user->avatar))){
                \storage::delete('public/'.$user->avatar);
            }
            $file = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $file;
        }
        $user->save();

        Session::flash('success','Data berhasil diedit');

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        Session::flash('success','Data berhasil dihapus');

        return redirect()->route('users.index');
    }
}
