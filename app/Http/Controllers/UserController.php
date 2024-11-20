<?php

namespace App\Http\Controllers;

use App\User;
use App\Centre;
use App\Department;
use App\Role;
use App\Application;
use App\Currency;
use App\Type;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Alert;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user==NULL) {
            return redirect('/');
        } else {
            $users = User::where('id', '!=', $user->id)->orderBy('status', 'ASC')->orderBy('updated_at', 'DESC')->get();
            $departments=Department::where('Status', '1')->where('id','!=', '11')->get();
            $centres = Centre::where('Status', '1')->where('CentreName', 'NOT LIKE', '%CEFL HQ%')->get();
            $roles = Role::where('Status', '1')->orderBy('RoleName','ASC')->get();

            return view('admin.allUser')->with(compact('user', 'users', 'departments', 'centres','roles'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user==NULL) {
            return redirect('/');
        } else {
            $centres = Centre::where('Status', '1')->get();
            $depts = Department::where('Status', '1')->orderBy('DeptName','ASC')->get();
            $roles = Role::where('Status', '1')->orderBy('RoleName','ASC')->get();

            return view('admin.register')->with(compact('user','centres', 'depts', 'roles'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:100',
            'email' => 'required|string|email|unique:user,email',
            'newpassword' => 'required|string',
        ]);

        if ($request->centre == '1') {
            $deptID=$request->dept;
        }else{
            $deptID='11';
        }

        $user = new User();
        $user->name = $request->fname;
        $user->email = $request->email;
        $user->password = Hash::make($request->newpassword);
        $user->deptID = $deptID;
        $user->roleID = $request->role;
        $user->centreID = $request->centre;
        if(!$user->save()){
            Alert::error("Whoops...", "Error 503: Service Unavailable");   
        }else{
            Alert::success("Sucessful.", "New user have been successfully created.");   
        }

        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        if ($user==NULL) {
            return redirect('/');    
        } else {
            $users = User::where(DB::raw('md5(id)'), $id)->first();
            $centres = Centre::where('Status', '1')->get();
            $depts = Department::where('Status', '1')->orderBy('DeptName','ASC')->get();
            $roles = Role::where('Status', '1')->orderBy('RoleName','ASC')->get();

            return view('admin.editUser')->with(compact('user','users', 'centres', 'depts', 'roles'));
        }
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

        $user = User::where(DB::raw('md5(id)'), $id)->first();
        if($user != NULL){
            if($request->listStatus == '2'){
                $user->Status=1;
                if(!$user->save()){
                    Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                }else{
                    Alert::success('Sucessful.', 'User have been successfully activated.');   
                }
                
                return redirect('users');

            }elseif ($request->listStatus == '1') {
                $user->Status=2;
                if(!$user->save()){
                    Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                }else{
                    Alert::success('Sucessful.', 'User have been successfully deactivated.');   
                }            

                return redirect('users');
            }else{
                $request->validate([
                    'name' => 'required|string|max:100',
                    'email' => 'required|string|email',
                ]);

                if ($request->newpassword==NULL) {
                    $password=$user->password;
                } else {
                    $password=Hash::make($request->newpassword);
                }

                if ($request->status==NULL) {
                    $status=2;
                } else {
                    $status=1;
                }
                
                $user->name=$request->name;
                $user->email=$request->email;
                $user->password=$password;
                $user->deptID=$request->dept;
                $user->roleID=$request->role;
                $user->centreID=$request->centre;
                $user->Status=$status;
                if(!$user->save()){
                    Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                }else{
                    Alert::success('Sucessful.', 'User have been successfully updated.');   
                }

                return redirect('users');
            }
        }else{
            Alert::error('Whoops...', 'Error 503: Service Unavailable');  
            return redirect('users'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function viewProfile()
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect('/');        
        } else {
            return view('profile')->with(compact('user'));
        }        
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:100',
            'email' => 'required|string|email|unique:user,email',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        if(!$user->save()){
            Alert::error('Whoops...', 'Error 503: Service Unavailable');   
        }else{
            Alert::success('Sucessful.', 'Your profile have been successfully updated.');   
        }

        return redirect('/profile');        
    }

    public function viewPassword()
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect('/');        
        } else {
            return view('changePassword')->with(compact('user'));
        } 
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'newpassword' => 'required|string',
        ]);

        $user = Auth::user();
        if ($user == NULL) {
            return redirect('/');        
        } else {
            if ($user->password != Hash::make($request->currentpassword)) {
                return view('changePassword')->with(compact('user'))->withErrors(['msg'=>'Current Password not Match']);
            } else {
                $user->password = Hash::make($request->confirmpassword);
                if(!$user->save()){
                    Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                }else{
                    Alert::success('Sucessful.', 'Your profile have been successfully updated.');   
                }        
        
                return redirect('/profile');  
            }
        } 
    }

    public function settings(){
        $user = Auth::user();
        $currencies = Currency::orderBy('updated_at')->get();
        $types = Type::orderBy('updated_at')->get();
        
        return view('admin.settings')->with(compact('user', 'currencies', 'types'));
    }

    
}
