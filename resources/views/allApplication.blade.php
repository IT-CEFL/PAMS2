<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Payment Approval Management System || All Application</title>
        <script>
            addEventListener("load", function () {
                setTimeout(hideURLbar, 0);
            }, false);

            function hideURLbar() {
                window.scrollTo(0, 1);
            }
        </script>
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
                        <div class="grid_3 grid_5 w3l">
                            <div class="alert alert-success" role="alert">
                                <strong>Welcome!</strong> View All Application History.
                            </div>
                        </div>
                        <div class="bs-docs-example table-responsive">
                            <table class="table table-striped table-hover table-bordered" id="item-history">
                                <thead>
                                    <tr class="table-info">
                                        <th>No.</th>
                                        <th>Application Number</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Date of Submission</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>                     
                                    @if(!$applications->isEmpty())
                                        @foreach($applications as $app)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$app->applicationNumber}}</td>
                                                <td>{{$app->user->name}}</td>
                                                <td>{{$app->user->email}}</td>
                                                <td>{{$app->type->typeName}}</td>
                                                <td>
                                                    {{date('h:i A', strtotime($app->created_at))}}
                                                    <br>
                                                    {{date('d-m-Y', strtotime($app->created_at))}}
                                                </td>
                                                <td>
                                                    @if($app->status=="")
                                                        Pending
                                                    @elseif($app->status=="Withdrawn")
                                                        Withdrawn
                                                    @elseif($app->status=="Completed")
                                                            Approved by Finance
                                                    @elseif($app->status=="Rejected")
                                                        Rejected by {{$app->applicationTracking->sortByDesc('created_at')->first()->approver->role->roleName}}
                                                    @elseif($app->status=="Approved")
                                                        Approved by {{$app->applicationTracking->sortByDesc('created_at')->first()->approver->role->roleName}}
                                                    @elseif($app->status=="Approved-Pending Docs")
                                                        Approved-Pending Docs by {{$request->applicationTracking->sortByDesc('created_at')->first()->approver->role->RoleName}}
                                                    @elseif($app->status=="Requiring Attention")
                                                        Requiring Attention by {{$app->applicationTracking->sortByDesc('created_at')->first()->approver->role->roleName}}
                                                    @else
                                                        Error 404
                                                    @endif
                                                </td>  
                                                <td class="text-center"><a href="/applications/{{$app->id}}" class="btn btn-info btn-sm rounded-pill"><b>View</b></a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <hr class="bs-docs-separator">
                    </div>
                    @include('../layout/footer')
                </div>
            </div>
        </div>
        <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
        <script src="{{asset('js/off-canvas.js')}}"></script>
        <script src="{{asset('js/hoverable-collapse.js')}}"></script>
        <script src="{{asset('js/template.js')}}"></script>
        <script src="{{asset('js/Chart.min.js')}}"></script>
        <script src="{{asset('js/dashboard.js')}}"></script>
        <script src="{{asset('js/jquery.barrating.min.js')}}"></script>
        <script>
                new DataTable('#item-history');
        </script>
    </body>
</html>