<?php

namespace App\Http\Controllers;
use App\User;
use App\Centre;
use App\Department;
use App\Role;
use App\Application;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function dashboard(Request $request){
        $user = Auth::user();
        if ($user==NULL) {
            return redirect('/');
        } else {
            if ($user->role->RoleName=='Admin') {
                //for user
                $totaluser = count(User::all());
                $active = count(User::where('Status', 1)->get());
                $inactive = count(User::where('Status', '0')->get());

                //for application
                $newItemapp = count(Application::where('status', NULL)->get());
                $onItemapp = count(Application::where('status', 'not like', '%Rejected%')->orWhere('status', 'not like', '%Completed%')->get());
                $rejItemapp = count(Application::where('status', 'like', '%Rejected%')->get());
                $compItemapp = count(Application::where('status', 'like', '%Completed%')->get());
                $withItemapp = count(Application::where('status', 'like', '%Withdrawn%')->get());

                return view('admin.dashboard')->with(compact('user', 'totaluser', 'active', 'inactive', 'newItemapp', 'onItemapp', 'rejItemapp','compItemapp','withItemapp'));
            } else{

                $totaluser = count(User::all());
                $active = count(User::where('Status', 1)->get());
                $inactive = count(User::where('Status', '0')->get());

                //for approval
                if($user->role->RoleName == "Finance Manager"){
                    $requests = Application::where('nextApp', $user->roleID)
                                ->whereHas('user', function($query) use ($user){
                                    $query->where('user.deptID', $user->deptID);
                                })
                                ->where(function($query) {
                                    $query->where('status', NULL)
                                        ->orWhere('status', 'NOT LIKE', '%Rejected%')
                                        ->orWhere('status', 'NOT LIKE', '%Completed%');
                                })->where('userID', '!=', $user->id)->get();
                    $requests = $requests->concat(Application::where('nextApp', '7')
                                ->where(function($query) {
                                    $query->where('status', NULL)
                                        ->orWhere('status', 'NOT LIKE', '%Rejected%')
                                        ->orWhere('status', 'NOT LIKE', '%Completed%');
                                })->where('userID', '!=', $user->id)->get());
                    $pendings = Application::where('pendings', "Like" ,"%$user->id%")->get();
                    if(!$pendings->isEmpty()){
                        foreach($pendings as $pending){
                            if(!$requests->isEmpty()){
                                $requests->diff($pendings);
                            }else{
                                $requests->push($pending);
                            }
                        }
                    }
                    $requests = $requests->sortByDesc('updated_at');

                }elseif($user->role->RoleName =="Operation Manager"){
                    $requests = Application::where('nextApp', $user->roleID)
                    ->whereHas('user', function($query) use ($user){
                        $query->where('user.deptID', $user->deptID);
                    })
                    ->where(function($query) {
                        $query->where('status', NULL)
                            ->orWhere('status', 'NOT LIKE', '%Rejected%')
                            ->orWhere('status', 'NOT LIKE', '%Completed%');
                    })->where('userID', '!=', $user->id)->get();

                    //pending docs request
                    $pendings = Application::where('pendings', "Like" ,"%$user->id%")->get();
                    if(!$pendings->isEmpty()){
                        foreach($pendings as $pending){
                            if(!$requests->isEmpty()){
                                $requests->diff($pendings);
                            }else{
                                $requests->push($pending);
                            }
                        }
                    }

                    $centReq = Application::where('nextApp', $user->roleID)
                                ->whereHas('user', function ($query) {
                                    return $query->where('deptID', 11);
                                })
                                ->where(function($query) {
                                    $query->where('status', NULL)
                                        ->orWhere('status', 'NOT LIKE', '%Rejected%')
                                        ->orWhere('status', 'NOT LIKE', '%Completed%');
                                })->where('userID', '!=', $user->id)->get();
                    if(!$centReq->isEmpty()){
                        foreach($centReq as $req){
                            if(!$requests->isEmpty()){
                                $requests->diff($centReq);
                            }else{
                                $requests->push($req);
                            }
                        }
                    }                            
                            
                    $requests = $requests->sortByDesc('updated_at'); 

                }elseif($user->role->RoleName == "Head Of Department"){
                    $requests = Application::where('nextApp', $user->roleID)
                        ->whereHas('user', function($query) use ($user){
                            $query->where('user.deptID', $user->deptID);
                        })
                        ->where(function($query) {
                            $query->where('status', NULL)
                                ->orWhere('status', 'NOT LIKE', '%Rejected%')
                                ->orWhere('status', 'NOT LIKE', '%Completed%');
                        })->where('userID', '!=', $user->id)->get();
    
                    //pending docs request
                    $pendings = Application::where('pendings', "Like" ,"%$user->id%")->get();
                    if(!$pendings->isEmpty()){
                        foreach($pendings as $pending){
                            if(!$requests->isEmpty()){
                                $requests->diff($pendings);
                            }else{
                                $requests->push($pending);
                            }
                        }
                    }
        
                    $requests = $requests->sortByDesc('updated_at'); 
                }else{
                    $requests = Application::where('nextApp', $user->roleID)
                                ->where(function($query) {
                                    $query->where('status', NULL)
                                        ->orWhere('status', 'NOT LIKE', '%Rejected%')
                                        ->orWhere('status', 'NOT LIKE', '%Completed%');
                                })->where('userID', '!=', $user->id)->get();
                                
                    $pendings = Application::where('pendings', "Like" ,"%$user->id%")->get();
                    if(!$pendings->isEmpty()){
                        foreach($pendings as $pending){
                            if(!$requests->isEmpty()){
                                $requests->diff($pendings);
                            }else{
                                $requests->push($pending);
                            }
                        }
                    }
                    $requests = $requests->sortByDesc('updated_at');
                }

                //submittedReq
                $submittedReq = Application::whereHas('applicationTracking', function ($query) use ($user){
                                    return $query->where('ApproverID', $user->id)->where('status', 'NOT LIKE', '%Approved-Pending Docs%');
                                })
                                ->where('userID', '!=', $user->id)->where('nextApp', '!=', $user->roleID)
                                ->where('status', 'NOT LIKE', '%Rejected%')->where('status', 'NOT LIKE', '%Completed%')
                                ->where('status', 'NOT LIKE', '%Withdrawn%')->get();

                if($user->role->RoleName == "Finance Manager"){
                    $submittedReq = $submittedReq->where('nextApp', '!=', '7');
                }
                    
                $newItemapp = count($requests);
                $onItemapp = count($submittedReq);
                $rejItemapp = count(Application::whereHas('applicationTracking', function ($query) use ($user){
                                        return $query->where('ApproverID', $user->id);
                                    })->where('userID', '!=', $user->id)
                                    ->where('Status', 'LIKE', '%Rejected%')->get());
                $compItemapp = count(Application::whereHas('applicationTracking', function ($query) use ($user){
                                        return $query->where('ApproverID', $user->id);
                                    })->where('userID', '!=', $user->id)
                                    ->where('Status', 'LIKE', '%Completed%')->get());
                $deptItemapp = count(Application::whereHas('user', function($query) use ($user){
                                        return $query->where('user.deptID', $user->deptID);
                                    })->where('userID', '!=', $user->id)->get());
                // for own application
                $allReq = count(Application::where('userID', $user->id)
                                ->where(function($query) {
                                    $query->where('status', 'NOT LIKE', '%Rejected%')
                                        ->where('status', 'NOT LIKE', '%Completed%')
                                        ->orWhere('status', NULL);
                                })->get());
                $rejReq = count(Application::where('userID', $user->id)->where('status', 'LIKE', '%Rejected%')->get());
                $compReq = count(Application::where('userID', $user->id)->where('status', 'LIKE', '%Completed%')->get());

                return view('dashboard')->with(compact('user', 'totaluser', 'active', 'inactive', 'newItemapp', 'onItemapp', 'rejItemapp','compItemapp','deptItemapp','allReq','rejReq', 'compReq'));
            }
        }
        
    }

    public function login(Request $request){
        $credentials= $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $request->remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            $user = Auth::user();
            // return back()->with(compact('user'));
            return redirect('/dashboard')->with(compact('user'));
        }else{
            return redirect()->back()->withErrors([
                'error'=> 'The provided credentials are not correct'
            ]);
        }


    }

    public function logout(Request $request){
        $user = Auth::user();
        Auth::logout();

        return redirect('/');
    }
}
