<!DOCTYPE html>
<html lang="en">

<head>
  <title>Payment Approval Management System || All Roles</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather.css')}}">
  <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">

  <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

  <!-- datatable -->
  <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">

<style>
    .toggle{
        width:100px !important;
    }
    .toggle-handle {
        background-color:white;
    }
    .btn-primary {
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
    .btn-primary:focus{
      background-color: #216ade !important;
      border-color: #216ade !important;
    }
    table{
      color:black !important;
    }
    .hoverless tbody tr:hover{
        background-color:white !important;
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
                        <li class="breadcrumb-item active" aria-current="page">All Roles</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-lg-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3>View All Roles</h3>
                                </div>
                                <div class="col">
                                    <div class="text-right">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#ModalAddCentre"  title="Edit">
                                            <b>Add new role <i class="icon-circle-plus"></i></b>
                                        </button>
                                    </div>
                                </div>

                            
                                <!-- Modal -->
                                <div class="modal fade" id="ModalAddCentre" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Add New Role</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/roles" method="post">
                                                @csrf
                                                @method('POST')
                                                <div class="modal-body">
                                                    <div class="form-group text-left">
                                                        <label for="name">Role Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="" required='true'>
                                                    </div>                         
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                            <div class="table-responsive pt-3">
                                <table class="table table-bordered table-hover" id="allRole">
                                    <thead>
                                        <tr class="table-info">
                                            <th class="align-middle text-center"><br>No.</th>
                                            <th class="align-middle"><br>Role Name</th>
                                            <th class="text-center"><br>Date Created</th>
                                            <th class="text-center"><br>Status</th>
                                            <th class="align-middle text-center no-sort" style="width:20%;"><br>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                 
                                        @foreach($roles as $role)
                                            <tr>
                                                <td style="text-align:center">{{$loop->iteration}}</td>
                                                <td>{{$role->RoleName}}</td>
                                                <td class="text-center">{{$role->created_at}}</td>      
                                                <td class="text-center">@if($role->Status==1) Active @else Inactive @endif</td>
                                                <td class="text-center" style="display: flex; justify-content: space-around;">
                                                    <form action="/roles/{{md5($role->id)}}" method="post" id="activeForm{{$role->id}}" style="flex">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="listStatus" value="{{$role->Status}}">
                                                        @if($role->Status==1)
                                                            <button onclick="confirmationDec(event,{{$role->id}})" class="btn btn-danger btn-sm btn-rounded" title="deactivate" style="padding-top: 11px !important; padding-bottom: 11px !important;"><i class="icon-circle-cross" style="font-size:large"></i></button>
                                                        @else
                                                            <button onclick="confirmationAct(event,{{$role->id}})" class="btn btn-success btn-sm btn-rounded" title="activate" style="padding-top: 11px !important; padding-bottom: 11px !important;"><i class="icon-circle-check"></i></button>
                                                        @endif
                                                    </form>

                                                    <a href="/roles/{{md5($role->id)}}/edit" class="btn btn-primary btn-rounded" title="Manage role"><i class="fa fa-pencil"></i></a>
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
        <!-- content-wrapper ends -->
      @include('../layout/footer')
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <script>
    $("input[name=status]").each(function(){
      $(this).bootstrapToggle('state', $(this).prop('checked'));
    });
    // $('#status').bootstrapToggle();

      var tables = $('#allRole').DataTable({
        orderCellsTop: true,
        dom: 'lfrtip',
        orderCellsTop: true,
        columnDefs: [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
      });
      tables.order.listener( '#sorter', 1 );
    
    function confirmationDec(e,id) {
      e.preventDefault();
      var form=document.getElementById("activeForm"+id);

      Swal.fire({
          icon: 'warning',
          title: 'Are you sure?',
          text: 'Are you sure to deactivate this role?',
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
          text: 'Are you sure to activate this role?',
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