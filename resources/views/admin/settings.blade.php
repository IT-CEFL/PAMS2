<!DOCTYPE html>
<html lang="en">

<head>
 
  <title>Payment Approval Management System || View Profile</title>
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
  <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  

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
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Settings</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row gutters-sm">
                        <div class="col-md-4 d-none d-md-block">
                            <div class="card">
                                <div class="card-body">
                                    <nav class="nav flex-column nav-pills nav-gap-y-1">
                                        <a href="#currency" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active">
                                            <i class="fa fa-money micon" style="font-size:16px;"></i> Currency
                                        </a>
                                        <a href="#types" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                                            <i class="fa fa-cogs micon" style="font-size:16px;"></i> Application Type
                                        </a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header border-bottom mb-3 d-flex d-md-none">
                                    <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                                        <li class="nav-item">
                                            <a href="#currency" data-toggle="tab" class="nav-link has-icon active"><i class="fa fa-money micon" style="font-size:16px;"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#types" data-toggle="tab" class="nav-link has-icon"><i class="fa fa-cogs micon" style="font-size:16px;"></i></a>
                                        </li>                        
                                    </ul>
                                </div>
                                <div class="card-body tab-content">
                                    <div class="tab-pane active" id="currency">
                                        <div class="row">
                                            <div class="col">
                                                <h3>Currencies</h3>
                                            </div>
                                            <div class="col">
                                                <div class="text-right">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#ModalAddCurrency"  title="Edit">
                                                        <b>Add New <i class="icon-circle-plus"></i></b>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="ModalAddCurrency" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Add New</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="/currencies" method="post">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="modal-body">
                                                                        <div class="form-group text-left">
                                                                            <label for="currencyName">Currency</label>
                                                                            <input type="text" class="form-control" id="currencyName" name="currencyName" value="" required='true'>
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
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="table-responsive pt3">
                                            <table class="table table-bordered table-hover" id="current">
                                                <thead class="table-info">
                                                    <tr>
                                                        <td class="text-center" style="width:15%">No.</td>
                                                        <td class="text-center">Currency</td>
                                                        <td class="text-center"style="width:30%">Action</td>
                                                    </tr>
                                                </thead> 
                                                <tbody>
                                                    @foreach($currencies as $currency)
                                                    <tr>
                                                        <td class="text-center">{{$loop->iteration}}</td>
                                                        <td>{{$currency->currencyName}}</td>
                                                        <td class="text-center no-sort" style="display: flex; justify-content: space-around;">
                                                            <button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#ModalEditCurrency{{$loop->iteration}}"  title="Edit">
                                                                <b>Edit</b>
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="ModalEditCurrency{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Currency</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form action="/currencies/{{$currency->id}}" method="post">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-body">
                                                                                <div class="form-group text-left">
                                                                                    <label for="currencyName">Currency</label>
                                                                                    <input type="text" class="form-control" id="currencyName" name="currencyName" value="{{$currency->currencyName}}" required='true'>
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
                                                            <form action="/currencies/{{$currency->id}}" id="deleteCurrencyForm{{$currency->id}}" method="post">
                                                                @csrf
                                                                @method('Delete')
                                                                <button onclick="deleteCurrency(event,{{$currency->id}})" class="btn btn-danger btn-rounded"><b>Delete</b></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>   
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="types">
                                        <div class="row">
                                            <div class="col">
                                                <h3>Application Types</h3>
                                            </div>
                                            <div class="col">
                                                <div class="text-right">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#ModalAddTypes"  title="Edit">
                                                        <b>Add New <i class="icon-circle-plus"></i></b>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="ModalAddTypes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Add New</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="/itemTypes" method="post">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="modal-body">
                                                                        <div class="form-group text-left">
                                                                            <label for="types">Item Type</label>
                                                                            <input type="text" class="form-control" id="types" name="types" value="" required='true'>
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
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="table-responsive pt3">
                                            <table class="table table-bordered table-hover" id="appTypes" style="width:100%">
                                                <thead class="table-info">
                                                    <tr>
                                                        <td class="text-center" style="width:15%!important;">No.</td>
                                                        <td class="text-center">Item Type</td>
                                                        <td class="text-center"style="width:30%!important;">Action</td>
                                                    </tr>
                                                </thead> 
                                                <tbody>
                                                    @foreach($types as $appType)
                                                    <tr>
                                                        <td class="text-center">{{$loop->iteration}}</td>
                                                        <td>{{$appType->typeName}}</td>
                                                        <td class="text-center no-sort" style="display: flex; justify-content: space-around;">
                                                            <button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#ModalEditType{{$loop->iteration}}"  title="Edit">
                                                                <b>Edit</b>
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="ModalEditType{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Item Type</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form action="/itemTypes/{{$appType->id}}" method="post">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-body">
                                                                                <div class="form-group text-left">
                                                                                    <label for="types">Item Type</label>
                                                                                    <input type="text" class="form-control" id="types" name="types" value="{{$appType->typeName}}" required='true'>
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
                                                            <form action="/itemTypes/{{$appType->id}}" id="deleteTypeForm{{$appType->id}}" method="post">
                                                                @csrf
                                                                @method('Delete')
                                                                <button deleteCurrency onclick="deleteType(event,{{$appType->id}})" class="btn btn-danger btn-rounded"><b>Delete</b></button>
                                                            </form>
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
    var tables = $('#current').DataTable({
        orderCellsTop: true,
        dom: 'lfrtip',
        orderCellsTop: true,
        columnDefs: [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
      });
      tables.order.listener( '#sorter', 1 );

    function deleteCurrency(e,id) {
      e.preventDefault();

      var form=document.getElementById("deleteCurrencyForm"+id);

      Swal.fire({
          icon: 'warning',
          title: 'Are you sure?',
          text: 'Are you sure to delete this currency?',
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
  <script>
    var tablesType = $('#appTypes').DataTable({
        orderCellsTop: true,
        autoWidth: false,
        dom: 'lfrtip',
        orderCellsTop: true,
        columnDefs: [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
      });
      tablesType.order.listener( '#sorter', 1 );

    function deleteType(e,id) {
      e.preventDefault();

      var form=document.getElementById("deleteTypeForm"+id);

      Swal.fire({
          icon: 'warning',
          title: 'Are you sure?',
          text: 'Are you sure to delete this item type?',
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