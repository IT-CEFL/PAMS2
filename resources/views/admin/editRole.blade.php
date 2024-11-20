<!DOCTYPE html>
<html lang="en">

<head>
  <title>Payment Approval Management System || Manage Role</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather.css')}}">
  <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">

  <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>

  <!-- datatable -->
  <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script> 
  
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  

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
    .btn-none{
        background-color:white !important;
        border:0px !important;
        
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
                                <li class="breadcrumb-item"><a href="/roles">All Roles</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Role</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h3>Manage Roles: {{$role->RoleName}}
                                        <button type="button" class="btn-none" data-toggle="modal" data-target="#ModalEditRole"  title="Edit Role">
                                            <i class="fa fa-pencil-square-o" style="font-size: large;vertical-align: top;"></i>
                                        </button>
                                        </h3>
                                        
                                        
                                        <div class="modal fade" id="ModalEditRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Role</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="/roles/{{md5($role->id)}}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group text-left">
                                                                <label for="name">Role Name</label>
                                                                <input type="text" class="form-control" id="name" name="name" value="{{$role->RoleName}}" required='true'>
                                                            </div>  
                                                            <div class="text-left">
                                                                <label>Status:</label>
                                                                <br><input type="checkbox" name="status" id="status" class="align-middle" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" @if($role->Status==1) checked @endif>
                                                            </div>
                                                            <br>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr class="table-info text-center">
                                                                        <td>Module</td>
                                                                        <td>Access</td>
                                                                    </tr>
                                                                </thead>
                                                                @foreach($modules as $module)
                                                                    <tr>
                                                                        <td>{{$module->moduleName}}</td>
                                                                        <td class="text-center">
                                                                            <input type="checkbox" name="module[]" value="{{$module->id}}" @foreach($accesses as $access) @if($module->id==$access->moduleID) checked @endif @endforeach >
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                            <br> 
                                                            <div class="text-left">
                                                                <label for="updated">Last update</label>
                                                                <input type="text" class="form-control" id="updated" name="updated" value="{{$role->updated_at}}" disabled>
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
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="text-right">
                                                <button class="btn btn-success btn-rounded" type="button" id="rowAdder"><b>Add New <i class="icon-circle-plus"></i></b></button>
                                            </div>
                                        </div>
                        
                                        <div class="table-responsive pt-3">
                                            <form action="/saveFlows/{{$role->id}}" method="post" id="saveflows">
                                                @csrf
                                                @method('POST')
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="align-middle" width="10%">Sequence</th>
                                                            <th class="text-center">Approver</th>
                                                            <th class="text-center">Amount Above</th>
                                                            <th class="text-center">Last Updates</th>
                                                            <th class="align-middle text-center no-sort" style="width:20%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tableFlow">
                                                        @if(!$flows->isEmpty())  
                                                            @foreach($flows as $flow)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <select name="sequence[]" class="form-select">
                                                                        @for($x=1;$x<=count($flows);$x++)
                                                                                <option value="{{$x}}" @if($x==$flow->sequence) selected @endif>{{$x}}</option>
                                                                        @endfor
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <div class="form-floating">
                                                                                <select name="approver[]" class="form-select" id="roles" aria-label="Floating label select">
                                                                                    @if($flow->Approver == NULL)
                                                                                        <option value=""selected dissabled>Please Choose</option>
                                                                                    @endif
                                                                                    @foreach($roles as $role)
                                                                                        <option value="{{$role->id}}" @if($role->id==$flow->Approver) selected @endif>{{$role->RoleName}}</option>
                                                                                    @endforeach 
                                                                                </select>
                                                                                <label for="roles">Role :</label>
                                                                            </div>

                                                                            <!-- <label for="roles" style="margin:0.5rem !important;"></label>
                                                                            <select name="approver[]" class="form-select form-select-sm" id="roles">
                                                                                @if($flow->Approver == NULL)
                                                                                    <option value=""selected dissabled>Please Choose</option>
                                                                                @endif
                                                                                @foreach($roles as $role)
                                                                                    <option value="{{$role->id}}" @if($role->id==$flow->Approver) selected @endif>{{$role->RoleName}}</option>
                                                                                @endforeach                                                                        
                                                                            </select> -->
                                                                        </div>
                                                                    </td>      
                                                                    <td class="text-center">
                                                                        <div class="input-group">
                                                                            @if($currencies)
                                                                                <span class="input-group-text fw-bold">{{$currencies->currencyName}}</span>
                                                                            @endif
                                                                            <input type="number" name="priceRange[]" step="0.01" class="form-control form-control-sm explamt" value="@if($flow->range!=NULL){{$flow->priceRange->amount}}@endif">
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">{{$flow->created_at}}</td>
                                                                    <td class="text-center">
                                                                        <form></form> <!-- for bug first row form -->
                                                                        <form action="/deleteFlow/{{$role->id}}/{{$flow->id}}" method="post" onsubmit="return submitResult(this);">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button class="btn btn-sm btn-danger" type="submit" title="remove"><i class="fa fa-minus-square" ></i></button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <br>
                                                <button type="submit" class="btn btn-primary float-end" id="save"><b><i class="fa fa-floppy-o"></i> Save</b></button>
                                            </form>
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
    <script type="text/javascript">
        if ($("rowAdder").length > 0) { 
            $("#rowAdder").trigger('click');
        }

        $('input.explamt').on('blur', function(){
            const v = $(this).val();
            if(isNaN(v) || v === "")//this line may need amending depending on validation
                return false;

            $(this).val(parseFloat(v).toFixed(2));
        });
    </script>
<script type="text/javascript">
    var roles = @json($roles);
    var flows = @json($flows);
    var curren = @json($currencies);

    var count = flows.length+1;        
    var option2;

    roles.forEach((element, index, array) => {
        option2+='<option value="'+element.id+'">'+element.RoleName+'</option>'; 
    });

    $("#rowAdder").click(function () {
            newRowAdd = 
            '<tr id="row">'+
                '<td class="text-center">'+
                    '<input type="number" class="form-control form-control-sm" name="sequence[]" value='+count+' readonly>'+
                '</td>'+
                '<td>'+
                    '<label for="roles" style="margin:0.5rem !important;">By Role :</label>'+
                    '<select name="approver[]" class="form-select form-select-sm" id="roles"><option value="" selected dissabled>Please Choose</option>'+option2+'</select>'+
                '</td>'+      
                '<td class="text-center">'+
                    '<div class="input-group">'+
                        '<span class="input-group-text fw-bold">'+curren.currencyName+'</span>'+
                        '<input type="number" class="form-control form-control-sm explamt" name="priceRange[]" step="0.01">'+
                    '</div>'+
                '</td>'+
                '<td class="text-center"> - </td>'+     
                '<td class="text-center">'+
                    '<button class="btn btn-sm btn-danger" type="button" id="DeleteRow" title="remove"><i class="fa fa-minus-square" ></i></button>'+
                '</td>'+
            '</tr>';
            $('#tableFlow').append(newRowAdd);
            count +=1;

    });

    $("body").on("click", "#DeleteRow", function () {
      $(this).parents("#row").remove();
        count -=1;
    });

    </script>
    <script>
        function submitResult(form) {
                // form.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Are you sure you want to remove this?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    const submitFormFunction = Object.getPrototypeOf(form).submit;
                    submitFormFunction.call(form);
                }else if(result.isCancel){
                    Swal.fire('Was not removed', '', 'info')
                }
            });
            return false;
            // if (!confirm('Are you sure?'))
            //     e.preventDefault();
        }
    </script>
</body>

</html>