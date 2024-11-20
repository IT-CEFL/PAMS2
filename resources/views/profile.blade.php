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
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h3>My Profile</h3>
                                    <br>
                                    <form action="/profile/update" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <input type="text" class="form-control" id="role" name="role" value="{{$user->role->RoleName}}" readonly="true">
                                        </div>
                                        <div class="form-group">
                                            <label for="centre">Centre</label>
                                            <input type="text" class="form-control" id="centre" name="centre" value="{{$user->centre->CentreName}}" readonly="true">
                                        </div>
                                        <div class="form-group">
                                            <label for="dept">Department</label>
                                            <input type="text" class="form-control" id="dept" name="dept" value="{{$user->dept->DeptName}}" readonly="true">
                                        </div>  
                                        <div class="form-group">
                                            <label for="regdate">Registration Date</label>
                                            <input type="text" class="form-control" id="regdate" name="regdate" value="{{$user->created_at}}" readonly="true">
                                        </div>
                                        <div class="form-group">
                                            <label for="update">Last Profile Update</label>
                                            <input type="text" class="form-control" id="update" name="update" value="{{$user->updated_at}}" readonly="true">
                                        </div>
                                        <br>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                                        </div>
                                    </form>
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
</body>

</html>