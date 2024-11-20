<?php

namespace App\Http\Controllers;

use App\Application;
use App\ApplicationTracking;
use App\Type;
use App\Currency;
use App\User;
use App\Mail\sendMail;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
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
            $types = Type::orderBy('typeName')->get();
            $currencies = Currency::orderBy('updated_at')->get();

            return view('appForm')->with(compact('user','types','currencies'));
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
        $user = Auth::user();
        // $user = User::find('22');

        $approve = $user->role->approvalFlow->sortBy('sequence');
        if($approve->first()->priceRange != NULL){
            if ($request->explamt >= $approve->first()->priceRange->amount && $request->currency == $approve->first()->priceRange->ccy) {
                $firstApp = $approve->first();
            }elseif ($request->currency != $approve->first()->priceRange->ccy) {
                $from = strtok(Currency::where('id', $request->currency)->pluck('currencyName')->first(), '(');
                $date = date('Y-m-j');
                $rate = (New RoleController)->exchangeRate($from, $date);
                if($rate == NULL){
                    Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                    return back();        
                }else{
                    $converted = round($request->explamt * $rate, 2);
                    if ($converted >= $approve->first()->priceRange->amount) {
                        $firstApp = $approve->first();
                    } else {
                        $prover = $approve->where('sequence', $approve->first()->sequence+1)->first();
                        $firstApp = $prover;
                    }
                }
            }else{
                $prover = $approve->where('sequence', $approve->first()->sequence+1)->first();
                $firstApp = $prover;
            }
        }else{
            $firstApp = $approve->first();
        }
        $app = new Application;
        $app->userID = $user->id;
        $app->applicationNumber = $this->generateUniqueCode();
        
        $files = time().'.'.$request->attachFile->extension();  
        $request->attachFile->move(public_path('suppDoc'), $files);
        $app->file = '/suppDoc/' . $files;
        
        $app->TypeID = $request->itemType;
        $app->CurrencyID = $request->currency;
        $app->expectedAmount = $request->explamt;
        $app->remark = $request->msgcmt;
        $app->nextApp = $firstApp->Approver;
        $app->sequence = $firstApp->sequence;
        
        if(!$app->save()){
            Alert::error('Whoops...', 'Error 503: Service Unavailable');   
        }else{
            if($user->centreID == "1" && $firstApp->approver->RoleName =="Head Of Department"){
                $users = User::where('roleID', $firstApp->Approver)->where('deptID', $user->deptID)->get();
            }else{
                $users = User::where('roleID',$firstApp->Approver)->get();
            }

            Mail::to("zhufri@cambridgeforlife.org")->send(new sendMail($app));

            // foreach($users as $sendTo){
                // Mail::to($sendTo->email)->send(new sendMail($email_data));
            // }

            Alert::success('Sucessful.', 'Application have been successfully submitted.');
        }

        return redirect('/applications');

    }

    public function generateUniqueCode()
    {
        //generate random unique application number
        do {
            $code = random_int(100000, 999999);
        } while (Application::where("applicationNumber", "=", $code)->first());
  
        return $code;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            $applications = Application::find($id);
            $applicationTrack = ApplicationTracking::where('ApplicationID',$id)->orderBy('created_at')->orderBy('updated_at')->get();

            return view('viewApplicationDetails')->with(compact('user', 'applications', 'applicationTrack'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $app = Application::find($id);
        $prevApp = $app->previousApp;
        $count = $app->sequence;
        
        $app->status = $request->status;
        $app->previousApp = $user->id;
        if($request->status == "Approved"){
            $approve = $app->user->role->approvalFlow->sortBy('sequence');
            if($approve == NULL){
                $app->nextApp = NULL;
                Alert::error('Whoops...', 'Error 404: Next approver not found');   
                return back();
            }elseif($approve->where('sequence', ($count+1))->first()->priceRange != NULL){
                if ($app->expectedAmount >= $approve->where('sequence', ($count+1))->first()->priceRange->amount && $app->CurrencyID == $approve->where('sequence', ($count+1))->first()->priceRange->ccy) {
                    $nextApp = $approve->where('sequence', ($count+1))->first();
                }elseif ($app->CurrencyID != $approve->where('sequence', ($count+1))->first()->priceRange->ccy) {
                    $from = strtok(Currency::where('id', $app->CurrencyID)->pluck('currencyName')->first(), '(');
                    $date = date('Y-m-j', strtotime($app->created_at));
                    $rate = (New RoleController)->exchangeRate($from, $date);
                    if($rate == NULL){
                        Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                        return back();        
                    }else{
                        $converted = round($app->expectedAmount * $rate, 2);  

                        if ($converted >= $approve->where('sequence', ($count+1))->first()->priceRange->amount ) {
                            $nextApp = $approve->where('sequence', ($count+1))->first();
                        }else{
                            $nextApp = $approve->where('sequence', ($count+2))->first();
                        }
                    }
                }else{
                    $nextApp = $approve->where('sequence', ($count+2))->first();
                }
                $app->nextApp = $nextApp->Approver;
                $app->sequence = $nextApp->sequence;
            }else{
                $nextApp = $approve->where('sequence', ($count+1))->first();
                $app->nextApp = $nextApp->Approver;
                $app->sequence = $nextApp->sequence;
            }
        }elseif($request->status == "Approved-Pending Docs"){
            if($app->pendings!=NULL){
                $newPending = json_decode($app->pendings);
                array_push($newPending, $user->id);
            }else{
                $newPending[] = $user->id;        
            }
            $app->pendings = json_encode($newPending);

            $approve = $app->user->role->approvalFlow->sortBy('sequence');
            if($approve == NULL){
                $app->nextApp = NULL;
                Alert::error('Whoops...', 'Error 404: Next approver not found');   
                return back();
            }elseif($approve->where('sequence', ($count+1))->first()->priceRange != NULL){
                if ($app->expectedAmount >= $approve->where('sequence', ($count+1))->first()->priceRange->amount && $app->CurrencyID == $approve->where('sequence', ($count+1))->first()->priceRange->ccy) {
                    $nextApp = $approve->where('sequence', ($count+1))->first();
                }elseif ($app->CurrencyID != $approve->where('sequence', ($count+1))->first()->priceRange->ccy) {
                    $from = strtok(Currency::where('id', $app->CurrencyID)->pluck('currencyName')->first(), '(');
                    $date = date('Y-m-j', strtotime($app->created_at));
                    $rate = (New RoleController)->exchangeRate($from, $date);
                    if($rate == NULL){
                        Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                        return back();        
                    }else{
                        $converted = round($app->expectedAmount * $rate, 2);
                        if ($converted >= $approve->where('sequence', ($count+1))->first()->priceRange->amount ) {
                            $nextApp = $approve->where('sequence', ($count+1))->first();
                        }else{
                            $nextApp = $approve->where('sequence', ($count+2))->first();
                        }
                    }
                }else{
                    $nextApp = $approve->where('sequence', ($count+2))->first();
                }
                $app->nextApp = $nextApp->Approver;
                $app->sequence = $nextApp->sequence;
            }else{
                $nextApp = $approve->where('sequence', ($count+1))->first();
                $app->nextApp = $nextApp->Approver;
                $app->sequence = $nextApp->sequence;
            }
        }elseif($request->status == "Requiring Attention"){
            $nextApp = $app->user->role->approvalFlow->where('sequence', $app->sequence-1)->first();
            $app->nextApp = $nextApp->Approver;
            $app->sequence = $nextApp->sequence;

            $AppTrack = ApplicationTracking::where('ApplicationID', $app->id)->where('ApproverID', $prevApp)->first();
            $AppTrack->attention = 1;
            if(!$AppTrack->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                return back();
            }

        }elseif($request->status == "Rejected"){
            $app->nextApp = NULL;
        }else{
            Alert::error('Whoops...', 'Error 404: Unknown status');   
            return back();
        }

        if(!$app->save()){
            Alert::error('Whoops...', 'Error 503: Service Unavailable');      
            return back();
        }else{
            $appTrack = new ApplicationTracking;
            $appTrack->ApplicationID = $app->id;
            $appTrack->ApproverID = $user->id;

            if($request->attachFile != Null){
                $files = time().'.'.$request->attachFile->extension();  
                $request->attachFile->move(public_path('suppDoc'), $files);
                $appTrack->fileUpload = '/suppDoc/' . $files;
            }

            $appTrack->remark = $request->remark;
            $appTrack->status = $request->status;
            $appTrack->save();

            if($app->user->centreID == "1" && $nextApp->approver->RoleName =="Head Of Department"){
                $users = User::where('roleID', $nextApp->Approver)->where('deptID', $user->deptID)->get();
            }else{
                $users = User::where('roleID',$nextApp->Approver)->get();
            }

            Mail::to("zhufri@cambridgeforlife.org")->send(new sendMail($app));

            // foreach($users as $sendTo){
                // Mail::to($sendTo->email)->send(new sendMail($email_data));
            // }
            Alert::success('Sucessful.', 'Application request have been successfully updated.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }

    public function withdrawApp(Request $request)
    {
        $id = (int) $request->route('app_id');
        $application = Application::find($id);
        $application->status = $request->status;
        $application->nextApp = NULL;
        if(!$application->save()){
            Alert::error('Whoops...', 'Error 503: Service Unavailable');   
        }else{
            Alert::success('Sucessful.', 'Application have been successfully withdrawn.');
        }
        return redirect('/applications/'.$id);
    }

    public function newApplication(Request $request)
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            $applications = Application::where('status', NULL)->orderBy('updated_at', 'DESC')->get();

            return view('admin.newApplication')->with(compact('user', 'applications'));
        }    
    }

    public function ongoingApplication(Request $request)
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            $applications = Application::where('status', 'NOT LIKE', '%Rejected%')->where('status', 'NOT LIKE', '%Completed%')->where('status', 'NOT LIKE', '%Withdrawn%')->orderBy('updated_at', 'DESC')->get();

            return view('admin.ongoingApplication')->with(compact('user', 'applications'));
        }
    }

    public function completedApplication(Request $request)
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            $applications = Application::where('status', 'like', '%Completed%')->orderBy('updated_at', 'DESC')->get();

            return view('admin.completedApplication')->with(compact('user', 'applications'));
        }
    }

    public function rejectedApplication(Request $request)
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            $applications = Application::where('status', 'like', '%Rejected%')->orderBy('updated_at', 'DESC')->get();

            return view('admin.rejectedApplication')->with(compact('user', 'applications'));
        }
    }

    public function withdrawnApplication(Request $request)
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            $applications = Application::where('status',"LIKE","Withdrawn")->orderBy('updated_at', 'DESC')->get();

            return view('admin.withdrawnApplication')->with(compact('user', 'applications'));
        }
    }
    
    public function allApplication()
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            $applications = Application::where('userID', $user->id)
            ->where(function($query) {
                $query->where('status', 'NOT LIKE', '%Rejected%')
                    ->where('status', 'NOT LIKE', '%Completed%')
                    ->orWhere('status', NULL);
            })
            ->orderBy('updated_at', 'DESC')->get();

            return view('allApplication')->with(compact('user', 'applications'));
        }
    }

    public function approvedApplication()
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            $applications = Application::where('userID', $user->id)->where('status', 'LIKE', '%Completed%')->orderBy('updated_at', 'DESC')->get();

            return view('approvedApplication')->with(compact('user', 'applications'));
        }
    }

    public function rejectApplication()
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            $applications = Application::where('userID', $user->id)->where('status', 'LIKE', '%Rejected%')->orderBy('updated_at', 'DESC')->get();

            return view('rejectedApplication')->with(compact('user', 'applications'));
        }
    }
    
    public function newRequest()
    {
        $user = Auth::user();

        if ($user == NULL) {
            return redirect('/');
        } else {
            if($user->role->RoleName == "Finance Manager"){
                $requests = Application::where('nextApp', $user->roleID)
                    ->whereHas('user', function($query) use ($user){
                        $query->where('user.deptID', $user->deptID);
                    })
                    ->where(function($query) {
                        $query->where('status', NULL)
                            ->orWhere('status', 'NOT LIKE', '%Rejected%')
                            ->orWhere('status', 'NOT LIKE', '%Completed%');
                    })->where('userID', '!=', $user->id)->orderBy('updated_at', 'DESC')->get();
                $requests = $requests->concat(Application::where('nextApp', '7')
                                                ->where(function($query) {
                                                    $query->where('status', NULL)
                                                        ->orWhere('status', 'NOT LIKE', '%Rejected%')
                                                        ->orWhere('status', 'NOT LIKE', '%Completed%');
                                                })->where('userID', '!=', $user->id)->orderBy('updated_at', 'DESC')->get());
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
                })->where('userID', '!=', $user->id)->orderBy('updated_at', 'DESC')->get();

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
                            })->where('userID', '!=', $user->id)->orderBy('updated_at', 'DESC')->get();
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
                    })->where('userID', '!=', $user->id)->orderBy('updated_at', 'DESC')->get();

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
                })->where('userID', '!=', $user->id)->orderBy('updated_at', 'DESC')->get();
                
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
            return view('newRequest')->with(compact('user', 'requests'));
        }
    }

    public function submittedRequest()
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect('/');
        } else {
            //(KIV FOR now its working fine)
            //problem with after previous person update (requiring attention)<-the next person should not appear here
            $requests = Application::whereHas('applicationTracking', function ($query) use ($user){
                return $query->where('ApproverID', $user->id)->where('status', 'NOT LIKE', '%Approved-Pending Docs%');
            })
            ->where('userID', '!=', $user->id)->where('nextApp', '!=', $user->roleID)->where('status', 'NOT LIKE', '%Rejected%')->where('status', 'NOT LIKE', '%Completed%')->where('status', 'NOT LIKE', '%Withdrawn%')
            ->orderBy('updated_at', 'DESC')->get();

            if($user->role->RoleName == "Finance Manager"){
                $requests = $requests->where('nextApp', '!=', '7');
            }

            return view('submittedRequest')->with(compact('user', 'requests'));
        }
    }

    public function completedRequest()
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect('/');
        } else {
            $requests = Application::whereHas('applicationTracking', function ($query) use ($user){
                return $query->where('ApproverID', $user->id);
            })->where('userID', '!=', $user->id)->where('Status', 'LIKE', '%Completed%')
            ->orderBy('updated_at', 'DESC')->get();

            return view('completedRequest')->with(compact('user', 'requests'));
        }
    }

    public function rejectedRequest()
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect('/');
        } else {
            $requests = Application::whereHas('applicationTracking', function ($query) use ($user){
                            return $query->where('ApproverID', $user->id);
                        })->where('userID', '!=', $user->id)->where('Status', 'LIKE', '%Rejected%')
                        ->orderBy('updated_at', 'DESC')->get();

            return view('submittedRequest')->with(compact('user', 'requests'));
        }
    }

    public function deptRequest(){
        $user = Auth::user();
        if ($user == NULL) {
            return redirect('/');
        } else {
            $requests = Application::whereHas('user', function($query) use ($user){
                            $query->where('user.deptID', $user->deptID);
                        })->where('userID', '!=', $user->id)->get();
            return view('deptRequest')->with(compact('user', 'requests'));
        }
    }

    public function updateTrackApplication(Request $request){
        $app_id = (int) $request->route('app_id');
        $track_id = (int) $request->route('track_id');
        
        $user = Auth::user();

        $app = Application::find($app_id);
        $track = ApplicationTracking::find($track_id);
        $prevApp = $app->previousApp;

        if($request->attachFile !=NULL){
            $files = time().'.'.$request->attachFile->extension(); 
            $request->attachFile->move(public_path('suppDoc'), $files);
            $track->fileUpload = '/suppDoc/' . $files;
        }

        $track->remark = $request->remark;
        $track->status = $request->status;

        if($request->status == "Approved"){
            if($track->attention == 1){
                $track->attention = 0;
            };

            if($app->pendings!=NULL){
                $newPending = json_decode($app->pendings);
                $newPending = array_diff($newPending, [$user->id]);
                $app->pendings = json_encode(array_values($newPending));
            }
            $app->status = $request->status;

            $approver = $app->user->role->approvalFlow->where('Approver', $user->roleID)->first();
            //for next approver
            $approve = $app->user->role->approvalFlow->where('sequence', ($approver->sequence+1))->first();
            if($approve == NULL){
                $app->nextApp = NULL;
                Alert::error('Whoops...', 'Error 404: Next approver not found');   
                return back();

            }elseif($approve->priceRange != NULL){
                if ($app->expectedAmount >= $approve->priceRange->amount &&  $app->CurrencyID == $approve->priceRange->ccy) {
                    $nextApp = $approve;
                }elseif ($app->CurrencyID != $approve->priceRange->ccy) {
                    $from = strtok(Currency::where('id', $app->CurrencyID)->pluck('currencyName')->first(), '(');
                    $date = date('Y-m-j', strtotime($app->created_at));
                    $rate = (New RoleController)->exchangeRate($from, $date);
                    if($rate == NULL){
                        Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                        return back();        
                    }else{
                        $converted = round($app->expectedAmount * $rate, 2);
                        if ($converted >= $approve->priceRange->amount) {
                            $nextApp = $approve;
                        }else{
                            $nextApp = $app->user->role->approvalFlow->where('sequence', ($approve->sequence+1))->first();
                        }
                    }
                }else{
                    $nextApp = $app->user->role->approvalFlow->where('sequence', ($approve->sequence+1))->first();
                }
                $app->nextApp = $nextApp->Approver;
                $app->sequence = $nextApp->sequence;
            }else{
                $nextApp = $approve;
                $app->nextApp = $nextApp->Approver;
                $app->sequence = $nextApp->sequence;
            }

        }elseif($request->status == "Approved-Pending Docs"){
            if($app->pendings!=NULL){
                $newPending = json_decode($app->pendings);
                array_push($newPending, $user->id);
            }else{
                $newPending[] = $user->id;        
            }
            $app->pendings = json_encode($newPending);
            $app->status = $request->status;

            if($track->attention == 1){
                $track->attention = 0;
            };

            $approve = $app->user->role->approvalFlow->where('Approver', $user->role->id)->first();

            if($approve == NULL){
                $app->nextApp = NULL;
                Alert::error('Whoops...', 'Error 404: Next approver not found');   
                return back();

            }elseif($approve->priceRange != NULL){
                if ($app->expectedAmount >= $approve->priceRange->amount && $app->CurrencyID == $approve->priceRange->ccy) {
                    $nextApp = $app->user->role->approvalFlow->where('sequence', ($approve->sequence+1))->first();
                }elseif ($app->CurrencyID != $approve->priceRange->ccy) {
                    $from = strtok(Currency::where('id', $app->CurrencyID)->pluck('currencyName')->first(), '(');
                    $date = date('Y-m-j', strtotime($app->created_at));
                    $rate = (New RoleController)->exchangeRate($from, $date);
                    if($rate == NULL){
                        Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                        return back();        
                    }else{
                        $converted = round($app->expectedAmount * $rate, 2);
                        if ($converted >= $approve->priceRange->amount) {
                            $nextApp = $app->user->role->approvalFlow->where('sequence', ($approve->sequence+1))->first();
                        }else{
                            $nextApp = $app->user->role->approvalFlow->where('sequence', ($approve->sequence+2))->first();
                        }
                    }
                }else{
                    $nextApp = $app->user->role->approvalFlow->where('sequence', ($approve->sequence+2))->first();
                }

                $app->nextApp = $nextApp->Approver;
                $app->sequence = $nextApp->sequence;
            }else{
                $nextApp = $app->user->role->approvalFlow->where('sequence', ($approve->sequence+1))->first();
                $app->nextApp = $nextApp->Approver;
                $app->sequence = $nextApp->sequence;
            }
        }elseif($request->status == "Requiring Attention"){
            $nextApp = $app->user->role->approvalFlow->where('sequence', $app->sequence-1)->first();
            $app->nextApp = $nextApp->Approver;
            $app->sequence = $nextApp->sequence;
            $app->status = $request->status;

            $AppTrack = ApplicationTracking::where('ApplicationID', $app_id)->where('ApproverID', $prevApp)->first();
            $AppTrack->attention = 1;
            if(!$AppTrack->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                return back();
            }

        }elseif($request->status == "Rejected"){
            $app->nextApp = NULL;
            $app->status = $request->status;
        }else{
            Alert::error('Whoops...', 'Error 404: Unknown status');   
            return back();
        }
        $app->previousApp = $user->id;

        if(!$app->save()){
            Alert::error('Whoops...', 'Error 503: Service Unavailable');      
            return back();
        }else{
            if(!$track->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');      
                return back();
            }
            
            if($app->user->centreID == "1" && $nextApp->approver->RoleName =="Head Of Department"){
                $users = User::where('roleID', $nextApp->Approver)->where('deptID', $user->deptID)->get();
            }else{
                $users = User::where('roleID',$nextApp->Approver)->get();
            }

            Mail::to("zhufri@cambridgeforlife.org")->send(new sendMail($app));

            // foreach($users as $sendTo){
                // Mail::to($sendTo->email)->send(new sendMail($email_data));
            // }
            Alert::success('Sucessful.', 'Application tracking have been successfully updated.');
            return back();
        }

    }

    public function disbursePage($id){
        $user = Auth::user();
        if ($user == NULL) {
            return redirect('/');
        } else {
            //application history tracking either stay sort updated_at or change back to created_at
            $applications = Application::find($id);
            $applicationTrack = ApplicationTracking::where('ApplicationID',$id)->orderBy('created_at')->get();

            return view('viewDisbursed')->with(compact('user', 'applications', 'applicationTrack'));
        }
    }

    public function disbursement(Request $request, $id){
        $user = Auth::user();

        $applications = Application::find($id);
        $prevApp = $applications->previousApp;

        if($request->status == "Approved"){
            $applications->status = "Completed";
            $applications->disbursedAmount = $request->lmd;
            $applications->previousApp = $user->id;
            $applications->nextApp = NULL;
            if($applications->pendings!=NULL){
                $newPending = json_decode($applications->pendings);
                $newPending = array_diff($newPending, [$user->id]);
            }else{
                $newPending = [];
            }
            $applications->pendings = json_encode($newPending);

            Mail::to("zhufri@cambridgeforlife.org")->send(new sendMail($applications));
            // Mail::to($applications->user->email)->send(new sendMail($applications));

        }elseif($request->status == "Approved-Pending Docs"){            
            $applications->disbursedAmount = $request->lmd;
            $applications->status = $request->status;
            $applications->previousApp = $user->id;
            $applications->nextApp = NULL;

            if($applications->pendings!=NULL){
                $newPending = json_decode($applications->pendings);
                array_push($newPending, $user->id);
            }else{
                $newPending[] = $user->id;        
            }
            $applications->pendings = json_encode($newPending);

        }elseif($request->status == "Requiring Attention"){
            $nextApp = $applications->user->role->approvalFlow->where('sequence', $applications->sequence-1)->first();
            $applications->status = $request->status;
            if($nextApp->priceRange != NULL){
                if($applications->expectedAmount >= $nextApp->priceRange->amount && $applications->CurrencyID == $nextApp->priceRange->ccy){
                    $applications->nextApp = $nextApp->Approver;
                }elseif ($applications->CurrencyID != $nextApp->priceRange->ccy) {
                    $from = strtok(Currency::where('id', $applications->CurrencyID)->pluck('currencyName')->first(), '(');
                    $date = date('Y-m-j', strtotime($app->created_at));
                    $rate = (New RoleController)->exchangeRate($from, $date);
                    if($rate == NULL){
                        Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                        return back();        
                    }else{
                        $converted = round($applications->expectedAmount * $rate, 2);
                        if ($converted >= $nextApp->priceRange->amount) {
                            $applications->nextApp = $nextApp->Approver;
                        }else{
                            $nextApp = $applications->user->role->approvalFlow->where('sequence', $applications->sequence-2)->first();
                            $applications->nextApp = $nextApp->Approver;
                        }
                    }
                }else{
                    $nextApp = $applications->user->role->approvalFlow->where('sequence', $applications->sequence-2)->first();
                    $applications->nextApp = $nextApp->Approver;
                }
            }else{
                $applications->nextApp = $nextApp->Approver;
            }
            $applications->sequence = $nextApp->sequence;

            $track = ApplicationTracking::where('ApplicationID', $applications->id)->where('ApproverID', $prevApp)->first();
            $track->attention = 1;
            if(!$track->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                return back();
            }

            if($applications->thePreviousApp->email != NULL){
                
                $users = User::where('id', $applications->previousApp)->get();
                
                Mail::to("zhufri@cambridgeforlife.org")->send(new sendMail($applications));
                // if(!$users->isEmpty()){
                //     foreach($users as $sendTo){
                //         Mail::to($sendTo->email)->send(new sendMail($applications));
                //     }
                // }

                $applications->previousApp = $user->id;
            }else{
                Alert::error('Whoops...', 'Error 404: Receiver email not found');   
                return back();
            }
            
        }elseif($request->status == "Rejected"){
            $applications->previousApp = $user->id;
            $applications->status = $request->status;
            $applications->nextApp = NULL;
        }else{
            Alert::error('Whoops...', 'Error 404: Unknown Status');   
            return back();
        }

        if(!$applications->save()){
            Alert::error('Whoops...', 'Error 503: Service Unavailable');   
            return back();
        }else{
            $appTrack = new ApplicationTracking;
            $appTrack->ApplicationID = $applications->id;
            $appTrack->ApproverID = $user->id;
            $appTrack->remark = $request->remark;
            $appTrack->status = $request->status;
            $appTrack->save();

            Alert::success('Sucessful.', 'Application request have been successfully updated.');
            return back();
        }

        return redirect('/applications/'.$id);
    }

    public function updateDisbursement(Request $request, $id){
        $app_id = (int) $request->route('app_id');
        $track_id = (int) $request->route('track_id');
        
        $user = Auth::user();

        $app = Application::find($app_id);
        $track = ApplicationTracking::find($track_id);
        $prevApp = $app->previousApp;

        if($request->attachFile !=NULL){
            $files = time().'.'.$request->attachFile->extension(); 
            $request->attachFile->move(public_path('suppDoc'), $files);
            $track->fileUpload = '/suppDoc/' . $files;
        }

        $track->remark = $request->remark;
        $track->status = $request->status;

        if($request->status == "Approved"){
            $app->disbursedAmount = $request->lmd;
            $app->status = "Completed";
            $app->previousApp = $user->id;
            $app->nextApp = NULL;

            if($app->pendings!=NULL){
                $newPending = json_decode($app->pendings);
                $newPending = array_diff($newPending, [$user->id]);
                $app->pendings = json_encode(array_values($newPending));
            }

            Mail::to("zhufri@cambridgeforlife.org")->send(new sendMail($app));
            // Mail::to($applications->user->email)->send(new sendMail($app));

        }elseif($request->status == "Approved-Pending Docs"){
            $app->disbursedAmount = $request->lmd;
            $app->status = $request->status;
            $app->previousApp = $user->id;
            $app->nextApp = NULL;

            if($app->pendings!=NULL){
                $newPending = json_decode($app->pendings);
                array_push($newPending, $user->id);
            }else{
                $newPending[] = $user->id;        
            }
            $app->pendings = json_encode($newPending);
            
        }elseif($request->status == "Requiring Attention"){

            $track = ApplicationTracking::where('ApplicationID', $app->id)->where('ApproverID', $prevApp)->first();
            $track->attention = 1;
            if(!$track->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');   
                return back();
            }

            $nextApp = $app->user->role->approvalFlow->where('sequence', $app->sequence-1);
            $applications->status = $request->status;
            $app->nextApp = $nextApp->Approver;
            $app->sequence = $nextApp->sequence;
            if($app->previousApp->email != NULL){
                $users = User::where('id', $app->previousApp)->get();
                
                Mail::to("zhufri@cambridgeforlife.org")->send(new sendMail($app));
                // if(!$users->isEmpty()){
                //     foreach($users as $sendTo){
                //         Mail::to($sendTo->email)->send(new sendMail($applications));
                //     }
                // }

                $app->previousApp = $user->id;
            }else{
                Alert::error('Whoops...', 'Error 404: Receiver email not found');   
                return back();
            }
            
        }elseif($request->status == "Rejected"){
            $app->previousApp = $user->id;
            $app->nextApp = NULL;
        }else{
            Alert::error('Whoops...', 'Error 404: Unknown Status');   
            return back();
        }

        if(!$app->save()){
            Alert::error('Whoops...', 'Error 503: Service Unavailable');      
            return back();
        }else{
            if(!$track->save()){
                Alert::error('Whoops...', 'Error 503: Service Unavailable');      
                return back();
            }
            
            Alert::success('Sucessful.', 'Application tracking have been successfully updated.');
            return back();
        }
    }
}
