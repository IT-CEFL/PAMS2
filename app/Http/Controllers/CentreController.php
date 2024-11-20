<?php

namespace App\Http\Controllers;
use App\Centre;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use Illuminate\Support\Facades\DB;

class CentreController extends Controller
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
            $centres = Centre::orderBy('Status','ASC')->orderBy('updated_at')->get();

            return view('admin.allCentre')->with(compact('centres','user'));
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

        $centre = new Centre();
        $centre->CentreName = $request->name;
        
        if(!$centre->save()){
            Alert::error('Whoops...', 'Error 503: Service Unavailable');      
        }else{
            Alert::success('Sucessful.', 'New Centre have been successfully created.');   
        }

        return redirect('centres');
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
        //
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

        $centre = Centre::where(DB::raw('md5(id)'), $id)->first();

        if($request->listStatus == '2'){
            $centre->Status=1;
            if(!$centre->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');      
            }else{
                Alert::success('Sucessful.', 'Centre have been successfully activate.');   
            }            
            return redirect('centres');

        }elseif ($request->listStatus == '1') {
            $centre->Status=2;
            if(!$centre->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');      
            }else{
                Alert::success('Sucessful.', 'Centre have been successfully deactivate.');   
            }
            
            return redirect('centres');
        }else{
            if ($request->status==NULL) {
                $status=2;
            } else {
                $status=1;
            }
            
            $centre->CentreName = $request->name;
            $centre->status=$status;
            if(!$centre->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');   
            }else{
                Alert::success('Sucessful.', 'Centre have been successfully updated.');   
            }

            return redirect('centres');
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
}
