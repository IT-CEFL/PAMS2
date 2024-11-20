<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Payment Approval Management System || Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather.css')}}">
  <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <!-- <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>   -->

  <link rel="stylesheet" href="{{asset('css/flag-icon.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/fontawesome-stars-o.css')}}">
  <link rel="stylesheet" href="{{asset('css/fontawesome-stars.css')}}">

    <style>
        .square-red {
            background-color: #FEB5A0;
        }

        .square-yellow {
            background-color: #FBEF35;
        }

        .square-lightgreen {
            background-color: #cefecd;
        }

        .square-green {
            background-color: #9dfc9c;
        }

        .square-blue{
            background-color: #B8FAF3;
        }

        .square-grey{
            background-color: #AFACAB;
        }

        .square-purple{
            background-color: #DFA1FC;
        }

        .square-pink{
            background-color: #FD95B0;
        }
        .card .card-body {
            padding: 1.875rem 1.875rem !important;
        }
        .application{
            border-top: 2px solid grey;
        }
    </style>

</head>

<body>
  <div class="container-scroller">
    @include('/layout/header')
    <div class="container-fluid page-body-wrapper">
      @include('/layout/sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              <h4 class="font-weight-bold text-dark">
                @if ($user)
                    Hi, welcome back! {{ $user->name }}
                @endif
              </h4>
            </div>
          </div>
          <div class="row mt-3 mb-4">
            <!-- first card-->
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body @if($totaluser >= 1) square-purple @endif">
                  <h4 class="card-title">Total Register Users</h4>
                  <h4>{{$totaluser}}</h4>
                  <a href="/users"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                </div>
              </div>
            </div>
            <!-- End of First Card -->

            <!-- Second card-->
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body @if($active >= 1) square-green @endif">
                  <h4 class="card-title">Total Active Users</h4>
                  <h4>{{$active}}</h4>
                  <a href="/users"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                </div>
              </div>
            </div>
            <!-- End of Second Card -->

            <!-- Third card-->
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body @if($inactive >= 1) square-pink @endif">
                  <h4 class="card-title">Total Inactive Users</h4>
                  <h4>{{$inactive}}</h4>
                  <a href="/users"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                </div>
              </div>
            </div>
            <!-- End of Third Card -->
          </div>

          <!-- Application row -->
          <div class="row application">
            <div class="col-sm-12 mb-4 mb-xl-0">
              <h4 class="font-weight-bold text-dark" style="margin-top:0.5rem;">All Application</h4>
            </div>
          </div>
          <div class="row mt-3">
            <!-- first card-->
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body @if($newItemapp >= 1) square-yellow @endif">
                  <h4 class="card-title">New Application</h4>
                  <h4>{{$newItemapp}}</h4>
                  <a href="/applications/new"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                </div>
              </div>
            </div>
            <!-- End of First Card -->

            <!-- Second card-->
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body @if($onItemapp >= 1) square-blue @endif">
                  <h4 class="card-title">Ongoing Application</h4>
                  <h4>{{$onItemapp}}</h4>
                  <a href="/applications/ongoing"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                </div>
              </div>
            </div>
            <!-- End of second card--> 

            <!-- Third card-->
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body @if($rejItemapp >= 1) square-red @endif">
                    <h4 class="card-title">Rejected Application</h4>
                    <h4>{{$rejItemapp}}</h4>
                      <a href="/applications/rejected"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                </div>
              </div>
            </div>
            <!-- End of Third card-->
            
            <!-- Start of Fourth card-->
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body @if($compItemapp >= 1) square-green @endif">
                  <h4 class="card-title">Completed Application</h4>
                  <h4>{{ $compItemapp }}</h4>
                  <a href="/applications/completed"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                </div>
              </div>
            </div>

            <!-- Start of Fifth card-->
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body @if($withItemapp >= 1) square-grey @endif">
                  <h4 class="card-title">Withdrawn Application</h4>
                  <h4>{{ $withItemapp }}</h4>
                  <a href="/applications/withdrawn"><h4 class="text-dark font-weight-bold mb-2">View Detail</h4></a>
                </div>
              </div>
            </div>           
          </div>
        </div>
        @include('/layout/footer')
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
</body>
</html>