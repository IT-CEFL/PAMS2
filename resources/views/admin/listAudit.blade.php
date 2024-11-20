<!DOCTYPE html>
<html lang="en">

<head>
  <title>Payment Approval Management System || Activity Log</title>
  <!-- base:css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/feather.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
  
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
  <!-- <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script> -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script> 
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<style>
    table{
      color:black !important;
    }
    th {
      text-align: center !important;
    }
    #daterange{
      font-size: 13px;
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
    .btn-success{
      background-color: #009933;
      border-color:  #006600;
      color:white;
    }
    .btn-success:hover{
      border-color:  #006600;
    }
    .btn-success2{
      background-color: #006600;
      border-color:  #006600;
      color:white;
    }
    .btn-success2:hover{
      background-color: #00b300;
      border-color:  #006600;
      color:white;
    }
    .dt-buttons{
      padding-bottom:10px;
    }
</style>
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
                        <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-lg-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3 >View Activity Log</h3>
                            <div class="table-responsive pt-3">
                                <table class="table table-bordered table-hover" id="audit">
                                    <thead align="center">
                                        <tr class="table-info">
                                          <th rowspan="2" class="align-middle no-sort">No.</th>
                                          <th rowspan="2" class="align-middle">User</th>
                                          <th rowspan="2" class="align-middle">Activity</th>
                                          <th colspan="2" class="align-middle">Details</th>
                                          <th style="width:10%">Date & Time</th>
                                        </tr>
                                        <tr class="table-info">
                                          <th style="border-bottom-color: rgba(0, 0, 0, 0.3) !important;width:25%;">
                                              Old Values
                                          </th>
                                          <th style="border-bottom-color: rgba(0, 0, 0, 0.3) !important;width:25%;">
                                              New Values
                                          </th>
                                          <th style="border-bottom-color: rgba(0, 0, 0, 0.3) !important;">
                                              <input type="text" name="daterange" id="daterange" value="" />
                                          </th>
                                        </tr>
                                    </thead>
                                    <tbody>                 
                                        @foreach($audits as $row)
                                            <tr>
                                                <td style="text-align:center">{{$loop->iteration}}</td>
                                                <td style="text-align:center">{{$row->user->name}}</td>
                                                <td style="text-align:center">
                                                    {{$row->event}}
                                                    @if (($pos = strpos($row->auditable_type, '\\')) !== FALSE)
                                                        {{$type = substr($row->auditable_type, strpos($row->auditable_type, '\\') + 1)}}
                                                    @endif
                                                </td> 
                                                @if($row->old_values!=NULL)
                                                  <td>
                                                    @foreach($row->old_values as $key=>$val)
                                                          {{$key}}: {{$val}}<br>
                                                    @endforeach
                                                  </td>
                                                @else
                                                  <td class="text-center">—</td>
                                                @endif         
                                                @if($row->new_values!=NULL)
                                                  <td>
                                                  @foreach($row->new_values as $key=>$val)
                                                      {{$key}}: {{$val}}<br>
                                                  @endforeach
                                                  </td>
                                                @else
                                                  <td class="text-center">—</td>
                                                @endif
                                                <td>{{$row->created_at}}</td>
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

  <!-- Datatable initialize -->
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
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
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
      // $.fn.dataTable.ext.search.pop();
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

    var tables = $('#audit').DataTable({
      orderCellsTop: true,
      dom: 'Blfrtip',
      buttons:[
        {
          extend:     'excel',
          // exportOptions: { columns: ':visible'},
          text: `<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel`,
          className: "btn btn-success",
          filename: default_name + "_excel"
        },
        {
          extend:     'csv',
          text:       `<i class="fa fa-file-o" aria-hidden="true"></i> CSV`,
          className: "btn btn-success2",
          filename: default_name + "_csv"
        },
      ]
      // columnDefs: [ {
      //   "targets": 'no-sort',
      //   "orderable": false,
      // } ]
    });
    tables.order.listener( '#sorter', 1 );
  
  </script>
</body>
</html>
