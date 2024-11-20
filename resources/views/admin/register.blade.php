<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Payment Approval Management System || Add New User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/feather.css')}}">
        <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>  
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
        <!-- endinject -->
        <!-- js-->
  <!-- container-scroller -->
</head>

<body>
    <div class="container-scroller">	
        @include('/layout/header')
	    <div class="container-fluid page-body-wrapper">
            @include('/layout/sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="/users">All Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add User</li>
                            </ol>
                        </nav>
                    </div>
                    @isset($message)
                    <div class="alert alert-success" role="alert">
                        {{$message}}
                    </div>
                    @endisset

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="container py-md-4 mt-md-3">
                    <h6>Please fill in the following details</h6>
                        <div class="card">
                            <div class="card-body">
                                <form action="/users" method="post" name="new_user_form" id="new_user_form" onSubmit="return valid();">
                                    @csrf
                                    @method("POST")
                                    <div class="contact_left_grid">
                                        <table width="100%" cellpadding="3" cellspacing="1">
                                            <tr>
                                                <td colspan="2">
                                                    <label style="font-size: 16px;">Name: </label>	
                                                    <input type="text" name="fname" value="" tabindex="1" required="true" class="form-control" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label style="font-size: 16px;padding-top: 20px;">Email: </label>	
                                                    <input type="text" name="email"  value="" tabindex="3" required="true" class="form-control" maxlength="100" pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label style="font-size: 16px;padding-top: 20px;">Centre: </label>
                                                    <select id="centre" name="centre" class="form-control" required="true" onChange="showDept();">
                                                        <option value="" selected disabled>Please Choose</option>
                                                        @if(count($centres) > 0)
                                                            @foreach($centres as $centre) 
                                                                <option value="{{ $centre->id }}">{{$centre->CentreName}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="row_dept" style="display:none;">
                                                <td colspan="2">
                                                    <label style="font-size: 16px;padding-top: 20px;">Department: </label>
                                                    <select id="dept" name="dept" class="form-control">
                                                        <option value="" selected disabled>Please Choose</option>
                                                        @if(count($depts) > 0)
                                                            @foreach($depts as $dept) 
                                                                <option value="{{$dept->id}}">{{$dept->DeptCode}} - {{$dept->DeptName}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"> 
                                                    <label style="font-size: 16px;padding-top: 20px;">Role: </label>
                                                    <select class="form-control" name="role" required="true">
                                                        <option value="" selected disabled>Please Choose</option>
                                                        @if(count($roles) > 0)
                                                            @foreach($roles as $role) 
                                                                <option value="{{$role->id}}">{{$role->RoleName}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                    <label style="font-size: 16px;padding-top: 20px;">Password: </label>	
                                                    <input name="newpassword" type="password" class="form-control" required="true"/>
                                                </td>
                                                <td width="50%">
                                                    <label style="font-size: 16px;padding-top: 20px;">Confirm Password: </label>	
                                                    <input name="confirmpassword" type="password" class="form-control" required="true"/> 
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="row" style="padding-top: 30px;">
                                            <div class="col-6">
                                                <p style="text-align:right;">
                                                    <input type="submit" value="Submit" name="submit" class="btn btn-primary" style="background-color: #3396ff; border:none;">
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p style="text-align:right;">
                                                    <input type="reset" value="Clear" class="btn btn-primary">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="clearfix"> </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @include('/layout/footer')
            </div>
	    </div>
    </div>
    <script src="{{ asset('js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="{{ asset('js/off-canvas.js')}}"></script>
  <script src="{{ asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{ asset('js/template.js')}}"></script>
<script>    
    function valid(){
        if(document.new_user_form.newpassword.value !== document.new_user_form.confirmpassword.value){
            swal.fire({
            icon: "error",
            title: "Password does not match",
            text: "New password and confirm password field does not match ",
            confirmButtonColor: "#3085d6"
            })
            document.new_user_form.confirmpassword.focus();
            return false;
        }
        return true;
    }

    function showDept(){
        if($('#centre').val()=== "1"){
            $('#row_dept').show();
            $('#dept').attr('required', '');
        }else{
            $('#row_dept').hide();
            $('#dept').removeAttr('required');   
        } 
    }

</script>
</body>
</html>