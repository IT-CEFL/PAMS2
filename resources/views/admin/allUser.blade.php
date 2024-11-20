<!DOCTYPE html>
<html lang="en">

<head>
  <title>Payment Approval Management System || All User</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- base:css -->
  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather.css')}}">
  <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <!-- endinject -->
  <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>

  <!-- date range picker -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <!-- datatable -->
  <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  

<style>
  #daterange{
      font-size: 12px;
    }

    .btn-primary {
      background-color: #216ade;
      border-color: #216ade;
    }
    .btn-primary:active {
      background-color: #216ade;
      border-color: #216ade;
    }
    .btn-primary:hover {
      background-color: #1a54b0;
      border-color: #1a54b0;
    }
    .btn-primary:disabled{
      background-color: #6a95d9;
      border-color: #6a95d9;
    }
    table{
      color:black !important;
    }
    .table td img{
      width: 25px !important;
      height: 25px !important;
    }
    .pad{
      padding:5px;
    }     
</style>
</head>

<body>
  <div class="container-scroller">
    @include('../layout/header')
    <div class="container-fluid page-body-wrapper">
        @include('../layout/sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Users</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-lg-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 >View All Users</h3>
                                    </div>
                                    <div class="col">
                                        <div class="text-right">
                                            <a href="/users/create" class="btn btn-success btn-rounded">
                                                <b>Add User <i class="icon-circle-plus"></i></b>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="table-responsive pt-3">
                                        <table class="table table-bordered table-hover" id="regUsers">
                                            <thead>
                                                <tr class="table-info">
                                                    <th rowspan="2" class="align-middle text-center">No.</th>
                                                    <th rowspan="2" class="align-middle" style="width:80%">Full Name</th>
                                                    <th rowspan="2" class="align-middle">Email</th>
                                                    <th class="text-center">Centre</th>
                                                    <th class="text-center" style="width:11%">Role</th>
                                                    <th class="text-center">Date of Registration</th>
                                                    <th class="text-center" style="width:11%">Status</th>
                                                    <th rowspan="2" class="align-middle text-center no-sort" style="width:11%">Action</th>
                                                </tr>
                                                <tr class="table-info">
                                                    <th>
                                                        <select name="" id="search-centre" class="form-control form-control-sm" style="padding-left:0px">
                                                        <option value="" default selected>All Centre</option>
                                                            <optgroup label="CEFL HQ">
                                                                @foreach($departments as $dept)
                                                                <option value="CEFL HQ - {{$dept->DeptCode}}">{{$dept->DeptName}}</option>';
                                                                @endforeach
                                                            </optgroup>

                                                            <optgroup label="CEFL Centre"> 
                                                                @foreach($centres as $centre)
                                                                    <option value="{{$centre->CentreName}}">{{$centre->CentreName}}</option>';
                                                                @endforeach
                                                            </optgroup>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <select name="" id="search-role" class="form-control form-control-sm" style="padding-left:0px;">
                                                        <option value="" default selected>All Role</option>
                                                        @foreach($roles as $role) 
                                                            <option value="{{$role->RoleName}}">{{$role->RoleName}}</option>
                                                        @endforeach
                                                        </select>
                                                    </th>
                                                    <th><input type="text" name="daterange" id="daterange" value="" class="form-control form-control-sm" style="padding-left:0px; padding-right: 0px;"/></th>
                                                    <th>
                                                        <select name="" id="search-status" class="form-control form-control-sm" style="padding-left:2%; padding-right: 0px;">
                                                        <option value="" default selected>All Status</option> 
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                        </select>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $usr) 
                                                <tr>
                                                    <td style="text-align:center">{{$loop->iteration}}</td>
                                                    <td>{{$usr->name}}</td>
                                                    <td>{{$usr->email}}</td>            
                                                    <td>
                                                    @if($usr->deptID!="11")
                                                        {{$usr->centre->CentreName}} - {{$usr->dept->DeptCode}}
                                                    @else
                                                        {{$usr->centre->CentreName}} 
                                                    @endif
                                                    </td>
                                                    <td>{{$usr->role->RoleName}}</td>            
                                                    <td>{{$usr->created_at}}</td>
                                                    <td>@if($usr->Status==1) Active @else Inactive @endif</td>
                                                    <td class="text-center" style="display: flex; justify-content: space-around;">
                                                        <form method="POST" action="/users/{{md5($usr->id)}}" id="activeForm{{$usr->id}}" onclick="@if($usr->Status==1) confirmationDec(event,{{$usr->id}}) @else confirmationAct(event,{{$usr->id}}) @endif">
                                                        @csrf
                                                        @method('PUT')
                                                            <input type="hidden" name="listStatus" value="{{$usr->Status}}">
                                                        @if($usr->Status==1)
                                                            <button title="Deactivate" class="btn btn-danger btn-rounded pad"><img src="../images/deactivate2.png"></button>
                                                        @else
                                                            <button title="Activate" class="btn btn-success btn-rounded pad"><img src="../images/activate2.png"></button>
                                                        @endif
                                                        </form>

                                                        <a href="/users/{{md5($usr->id)}}/edit" class="btn btn-primary btn-rounded pad" title="Edit user"><img src="../images/edit2.png" title="Edit User"></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
    
    var minDateFilter = "";
    var maxDateFilter = "";
    
    var dateRange = new daterangepicker('input[name="daterange"]', {
      cancelClass: "btn-danger",
      applyButtonClasses: "btn-primary",
      showDropdowns: true,
      opens: "center",
      drops: "auto",
      autoUpdateInput: false,
      locale: {
          format: 'DD/MM/YYYY',
          cancelLabel: 'Clear' 
        }
      // },function(start, end) {
      //   tables.draw();
    });

    $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        minDateFilter = Date.parse(dateRange.startDate.format('YYYY-MM-DD HH:mm:ss'));
        maxDateFilter = Date.parse(dateRange.endDate.format('YYYY-MM-DD HH:mm:ss'));
        var date = Date.parse(data[5]);
        if (
          (isNaN(minDateFilter) && isNaN(maxDateFilter)) ||
          (isNaN(minDateFilter) && date <= maxDateFilter) ||
          (minDateFilter <= date && isNaN(maxDateFilter)) ||
          (minDateFilter <= date && date <= maxDateFilter)
        ) {
          return true;
        }
        return false;
      });  
      tables.draw();  
    //   $.fn.dataTable.ext.search.pop();
    });

    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
      $('input[name="daterange"]').val('');
      $.fn.dataTable.ext.search = [];
        tables.draw();
    });

    // for file name
    const date = new Date();
    const yyyy = date.getFullYear();
    let mm = date.getMonth() + 1; // Months start at 0!
    let dd = date.getDate();
    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;
    const formattedToday = dd + '/' + mm + '/' + yyyy;
    const time = date.toLocaleTimeString([],{ hour12: false});
    var default_name = time+`_`+formattedToday;

      var tables = $('#regUsers').DataTable({
        orderCellsTop: true,
        dom: 'lfrtip',
        orderCellsTop: true,
        columnDefs: [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
      });
      tables.order.listener( '#sorter', 1 );

      $('#search-centre').on('change', function(){
          tables
          .column(3)
          .search(this.value)
          .draw();

      });
      $('#search-role').on('change', function(){
          tables
          .column(4)
          .search(this.value)
          .draw();

      });
      $('#search-status').on('change', function(){
          tables
          .column(6)
          .search(this.value)
          .draw();

      });

    function confirmationDec(e,id) {
        e.preventDefault();
        var form=document.getElementById("activeForm"+id);

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'Are you sure to deactivate this user?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                form.submit();
            }
        })
    }

    function confirmationAct(e,id) {
        e.preventDefault();
        var form=document.getElementById("activeForm"+id);

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'Are you sure to activate this user?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                form.submit();
            }
        })
    }
      
  </script> 
</body>
</html>