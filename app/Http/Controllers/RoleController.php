<?php

namespace App\Http\Controllers;
use Alert;
use App\Role;
use App\ApprovalFlow;
use App\Centre;
use App\Department;
use App\Module;
use App\Access;
use App\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class RoleController extends Controller
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
            $roles = Role::orderBy('Status','ASC')->orderBy('updated_at')->get();

            return view('admin.allRole')->with(compact('roles','user'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $role = new Role();
        $role->RoleName = $request->name;
        if(!$role->save()){
            Alert::error('Whoops...', 'Error 503: Service Unavailable');  
            return redirect('roles'); 
        }else{
            Alert::success('Sucessful.', 'New role have been successfully created.');    
            return redirect('roles/'.md5($role->id).'/edit');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=Auth::user();
        $role = Role::where(DB::raw('md5(id)'), $id)->first();
        $flows= ApprovalFlow::where(DB::raw('md5(roleID)'), $id)->orderBy('sequence', 'ASC')->get();
        $currencies = Currency::find('1');
        $centres = Centre::where('Status', '1')->get();
        $depts = Department::where('Status', '1')->orderBy('DeptName','ASC')->get();
        $roles = Role::where('Status', '1')->orderBy('RoleName','ASC')->get();
        $modules = Module::where('Status', '1')->orderBy('moduleName','ASC')->get();
        $accesses = Access::where(DB::raw('md5(roleID)'), $id)->get();

        return view('admin.editRole')->with(compact('user', 'role', 'flows','currencies','centres', 'depts', 'roles', 'modules', 'accesses'));
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
        $role = Role::where(DB::raw('md5(id)'), $id)->first();
        if($request->listStatus == '2'){
            $role->Status=1;
            if(!$role->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');   
            }else{
                Alert::success('Sucessful.', 'Role have been successfully activate.');   
            }

            return redirect('roles');

        }elseif ($request->listStatus == '1') {
            $role->Status=2;
            if(!$role->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');   
            }else{
                Alert::success('Sucessful.', 'Role have been successfully deactivate.');   
            }
                        
            return redirect('roles');
        }else{
            if ($request->status==NULL) {
                $status=2;
            } else {
                $status=1;
            }
            
            $role->RoleName = $request->name;
            $role->status=$status;
            if(!$role->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');   
            }else{
                $modules = $request->module;

                $accesses = Access::where(DB::raw('md5(roleID)'), $id)->delete();

                for($x=0;$x<count($modules);$x++){
                    $access = new Access;
                    $access->roleID = $role->id;
                    $access->moduleID = $modules[$x];
                    $access->save();
                }

                Alert::success('Sucessful.', 'Role have been successfully updated.'); 
            }
              
            return redirect('roles/'.md5($role->id).'/edit');
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

    public function exchangeRate($currency_code, $date){
        $currency_code = $request->route('currency_code');
        $date = date('Y-m-j', strtotime($request->route('date')));

        $now = date('Y-m-j');
        $hrs = date('Hi');

        if(strtotime($now) == strtotime($date)){
            $uri = "https://api.bnm.gov.my/public/exchange-rate/".$currency_code;
        }else{
            $uri = "https://api.bnm.gov.my/public/exchange-rate/".$currency_code."/date/".$date;
        }

        $client = new \GuzzleHttp\Client(['verify' => false, 'http_errors' => false]);
        $response = $client->request('GET', $uri, [
            'headers' => [
                'Accept'     => 'application/vnd.BNM.API.v1+json'
            ]
        ]);
        $result = json_decode($response->getBody()->getContents());

        if(isset($result->message)){
            if($result->message == "No records found."){
                //currency market session by BNM2024
                $sessions = array(1700,1200,1130,900, date('Y-m-j', strtotime(' -1 day')), date('Y-m-j', strtotime(' -2 day')));
                $index = 0;
                foreach($sessions as $session){
                    if(gettype($sessions[$index]) == "string"){
                        $uri = "https://api.bnm.gov.my/public/exchange-rate/".$currency_code."/date/".$date;
                    }else{
                        $uri = "https://api.bnm.gov.my/public/exchange-rate/".$currency_code."?session=".$sessions[$index];
                    }

                    $response = $client->request('GET', $uri, [
                        'headers' => [
                            'Accept'     => 'application/vnd.BNM.API.v1+json'
                        ]
                    ]);
                    $result = json_decode($response->getBody()->getContents());
                    if(!isset($result->message)){
                        break;
                    }
                }
            }
        }

        if(isset($result->data->rate->buying_rate)){
            return $result->data->rate->buying_rate;
        }else{
            Alert::error('Whoops...', 'Error 503: Service Unavailable');   
            return back();        
        }
    }
}
