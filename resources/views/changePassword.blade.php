<!DOCTYPE html>
<html lang="en">

<head>
 
  <title>Payment Approval Management System || Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather.css')}}">
  <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  
  <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
  <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>  
 
</head>

<body>
    <script>
        function checkpass()
        {
            if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
            {
                swal.fire({
                icon: "error",
                title: "Password does not match",
                text: "New password and confirm password field does not match ",
                confirmButtonColor: "#3085d6"
                })
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }  
    </script>
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
                                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h3>Change Password</h3>
                                    <br>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form class="forms-sample" action="/password/update" method="post" onsubmit="return checkpass(event);" name="changepassword">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="exampleInputName1">Current Password</label>
                                            <input type="password" class="form-control" name="currentpassword" id="currentpassword" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail3">New Password</label>
                                            <input type="password" class="form-control" name="newpassword"  class="form-control" required="true">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword4">Confirm Password</label>
                                            <input type="password" class="form-control"  name="confirmpassword" id="confirmpassword"  required='true'>
                                        </div>
                                    
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Change</button>
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