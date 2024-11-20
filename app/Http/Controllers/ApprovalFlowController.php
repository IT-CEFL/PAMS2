<?php

namespace App\Http\Controllers;

use App\ApprovalFlow;
use App\PriceRange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
class ApprovalFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function saveFlows(Request $request)
    {
        $role_id = (int)$request->route('role_id');
        $sequence = $request->sequence;
        $approver = $request->approver;
        $countObj = count($sequence);
        $priceRange = $request->priceRange;
        $dept=$request->dept;
        $flows= ApprovalFlow::where('roleID', $role_id)->get();

        foreach($flows as $flow){
            if($flow->range != NULL) {
                PriceRange::where('id', $flow->range)->delete();
            }
        }
        ApprovalFlow::where('roleID', $role_id)->delete();

        for($x=0;$x<$countObj;$x++){
            $price_id = NULL;
            if($priceRange[$x]!=NULL) {
                $price = new PriceRange;
                $price->amount=$priceRange[$x];
                $price->save();
                $price_id = $price->id;
            }

            $flow = new ApprovalFlow;
            $flow->sequence = $sequence[$x];
            $flow->roleID = $role_id;
            $flow->approver = $approver[$x];
            $flow->range = $price_id;
            $bol[] = $flow->save();
        }
        //check if all is succefully save
        $result = (bool) array_product($bol);

        if($result == true){
            Alert::success('Sucessful.', 'Flow have been successfully saved.');   
        }else{
            Alert::error('Whoops...', 'Error 503: Service Unavailable');   
        }
        
        return redirect('/roles/'.md5($role_id).'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApprovalFlow  $approvalFlow
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovalFlow $approvalFlow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApprovalFlow  $approvalFlow
     * @return \Illuminate\Http\Response
     */
    public function edit(ApprovalFlow $approvalFlow)
    {
        //
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApprovalFlow  $approvalFlow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApprovalFlow $approvalFlow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApprovalFlow  $approvalFlow
     * @return \Illuminate\Http\Response
     */
    public function deleteFlow(Request $request, ApprovalFlow $approvalFlow)
    {
        $role_id = (int)$request->route('role_id');
        $appFlow_id = (int)$request->route('appFlow_id');

        $flow = ApprovalFlow::find($appFlow_id);
        if($flow->range != NULL){
            $result = PriceRange::where('id', $flow->range)->delete();
            if ($result == true) {
                $flow->delete();
            }else{
                Alert::error('Whoops...', 'Error 503: Service Unavailable');
                return back();   
            }
        }else{
            $flow->delete();
        }

        $flows= ApprovalFlow::where('roleID', $role_id)->orderBy('sequence', 'ASC')->get();
        
        $count = 1;
        foreach($flows as $flow){
            $flow->sequence = $count;
            $flow->save();
            $count++;
        }

        return redirect('/roles/'.md5($role_id).'/edit');
    }
}
