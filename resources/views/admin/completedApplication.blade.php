<!DOCTYPE html>
<html lang="en">

<head>
 
  <title>Payment Approval Management System || Completed Application</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather.css')}}">
  <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  
  <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>

  <script src="{{asset('js/jquery-3.7.0.min.js')}}"></script>
  <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
 
</head>

<body>
    <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
        @include('../layout/header')
        <div class="container-fluid page-body-wrapper">
        
            @include('../layout/sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 stretch-card">
                            <div class="card">
                                <div class="card-header" style="background:white; border-bottom: none">
                                    <h3 >New Application</h3>
                                </div>
                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered table-hover" id="new-req"><!-- modified by HD 20230817 added class table-hover-->
                                        <thead>
                                            <tr class="table-info"><!-- modified by HD 20230817 added class table-info-->
                                                <th>No</th>
                                                <th>Application No.</th>
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
                                            @foreach($applications as $row)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$row->applicationNumber}}</td>
                                                    <td>{{$row->user->name}}</td>
                                                    <td>{{$row->user->email}}</td>
                                                    <td>{{$row->type->typeName}}</td>
                                                    <td>
                                                        @if($row->user->centre->id == 1)
                                                            {{$row->user->centre->CentreName." - ".$row->user->dept->DeptName}}
                                                        @else
                                                            {{$row->user->centre->CentreName}}
                                                        @endif
                                                    </td>
                                                    <td>{{$row->created_at}}</td>
                                                    <td>
                                                        @if($row->status=="")
                                                            Not Response Yet
                                                        @elseif($row->status=="Withdrawn")
                                                            Withdrawn
                                                        @elseif($row->status=="Completed")
                                                            Approved by Finance
                                                        @elseif($row->status=="Rejected")
                                                            Rejected by {{$row->applicationTracking->sortByDesc('created_at')->first()->approver->role->RoleName}}
                                                        @elseif($row->status=="Approved")
                                                            Approved by {{$row->applicationTracking->sortByDesc('created_at')->first()->approver->role->RoleName}}
                                                        @elseif($row->status=="Approved-Pending Docs")
                                                            Approved-Pending Docs by {{$row->applicationTracking->sortByDesc('created_at')->first()->approver->role->RoleName}}
                                                        @elseif($row->status=="Requiring Attention")
                                                            Requiring Attention by {{$row->applicationTracking->sortByDesc('created_at')->first()->approver->role->RoleName}}
                                                        @else
                                                            Error 404
                                                        @endif
                                                    </td>
                                                    <td><a href="/applications/{{$row->id}}" class="btn btn-info btn-sm rounded-pill"><b>View</b></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                @include('../layout/footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
  <!-- container-scroller -->
  <script>
    new DataTable('#new-req');
  </script>
</body>

</html>