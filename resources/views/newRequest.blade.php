<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            h3{
                font-family: "Raleway", 'san-serif';
                font-weight: 700 !important;
                color:  #404040;
            }
        </style>
        <title>Payment Approval Management System || New Request</title>
        <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/feather.css')}}">
        <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

        <link rel="stylesheet" href="{{asset('css/flag-icon.min.css')}}"/>
        <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/fontawesome-stars-o.css')}}">
        <link rel="stylesheet" href="{{asset('css/fontawesome-stars.css')}}">

        <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
        <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
    </head>
    <body>
        <div class="container-scroller">
            @include('../layout/header')
            <div class="container-fluid page-body-wrapper">
                @include('../layout/sidebar')
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="card">
                            <div class="card-header" style="background:white; border-bottom: none">
                                <h3>New Request</h3>
                            </div>
                            <div class="table-responsive pt-3">
                                <table class="table table-bordered table-hover" id="req-new">
                                    <thead>
                                        <tr class="table-info">
                                            <th>No.</th>
                                            <th>Application Number</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Centre</th>
                                            <th>Date of Submission</th>
                                            <th>Status</th>		
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requests as $request)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$request->applicationNumber}}</td>
                                                <td>{{$request->user->name}}</td>
                                                <td>{{$request->user->email}}</td>
                                                <td>{{$request->type->typeName}}</td>
                                                <td>
                                                    @if($request->user->centreID == '1')
                                                        {{$request->user->centre->CentreName}} − {{$request->user->dept->DeptCode}}
                                                    @else
                                                        {{$request->user->centre->CentreName}}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{date('h:i A', strtotime($request->created_at))}}
                                                    <br>
                                                    {{date('d-m-Y', strtotime($request->created_at))}}
                                                </td>
                                                <td>
                                                    @if($request->status==NULL)
                                                        Pending
                                                    @elseif($request->status=="Withdrawn")
                                                        Withdrawn
                                                    @elseif($request->status=="Completed")
                                                            Approved by Finance
                                                    @elseif($request->status=="Rejected")
                                                        @if($request->user->centreID != '1' && $request->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName=="Head Of Department" && $request->applicationTracking->sortByDesc('updated_at')->first()->approver->deptID=="1")
                                                            Rejected by Operation Manager
                                                        @else
                                                            Rejected by {{$request->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName}}
                                                        @endif
                                                    @elseif($request->status=="Approved")
                                                        @if($request->user->centreID != '1' && $request->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName=="Head Of Department" && $request->applicationTracking->sortByDesc('updated_at')->first()->approver->deptID=="1")
                                                            Approved by Operation Manager
                                                        @elseif($request->nextApp == NULL)
                                                            Approved-Pending Docs by Finance
                                                        @else
                                                            Approved by {{$request->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName}}
                                                        @endif
                                                    @elseif($request->status=="Approved-Pending Docs")
                                                        @if($request->user->centreID != '1' && $request->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName=="Head Of Department" && $request->applicationTracking->sortByDesc('updated_at')->first()->approver->deptID=="1")
                                                            Approved-Pending Docs by Operation Manager
                                                        @elseif($request->nextApp == NULL)
                                                            Approved-Pending Docs by Finance
                                                        @else
                                                            Approved-Pending Docs by {{$request->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName}}
                                                        @endif
                                                    @elseif($request->status=="Requiring Attention")
                                                        @if($request->previousApp == NULL)
                                                            Requiring Attention by Finance
                                                        @else
                                                            Requiring Attention by {{$request->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName}}
                                                        @endif
                                                    @else
                                                        Error 404
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                @if($user->deptID=="8" && $request->sequence == count($request->user->role->approvalFlow))
                                                    <a href="/applications/disburse/{{$request->id}}" class="btn btn-info btn-sm rounded-pill"><b>View</b></a> 
                                                @else
                                                    <a href="/applications/{{$request->id}}" class="btn btn-info btn-sm rounded-pill"><b>View</b></a>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @include('../layout/footer')
            </div>
            </div>
        </div>
        <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
        <script src="{{asset('js/off-canvas.js')}}"></script>
        <script src="{{asset('js/hoverable-collapse.js')}}"></script>
        <script src="{{asset('js/template.js')}}"></script>
        <script>
            new DataTable('#req-new');
        </script>
    </body>
</html>
