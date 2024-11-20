<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Payment Approval Management System || Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather.css')}}">
  <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <h3 style="font-style: italic;">Payment Approval Management System</h3>
              </div>
              <h4>Welcome back!</h4>
              <h6 class="font-weight-light">Happy to see you again!</h6>
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    <li>{{$errors->first()}}</li>
                  </ul>
                </div>
              @endif

              <form class="pt-3" method="POST" action="/login">
                @csrf
                @method("POST")
                <div class="form-group">
                  <label for="exampleInputEmail">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control form-control-lg border-left-0" placeholder="Email" required="true" name="email" value="" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    
                    <input type="password" class="form-control form-control-lg border-left-0" placeholder="Password" name="password" required="true" value="">                       
                  </div>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">   
                      <input type="checkbox" id="remember" class="form-check-input" name="remember">
                      Keep me signed in
                    </label>
                  </div>
                  <!-- <a href="forgot-password.php" class="auth-link text-black">Forgot password?</a> -->
                </div>
                <div class="my-3">
                
                  <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn bounce" name="login">LOGIN</button>
                  <br>
               
                </div>
               
              </form>
            </div>

          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Payment Approval Management System @ 2024.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <script src="{{ asset('/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="{{ asset('/js/off-canvas.js')}}"></script>
  <script src="{{ asset('/js/hoverable-collapse.js')}}"></script>
  <script src="{{ asset('/js/template.js')}}"></script>
</body>

</html>
