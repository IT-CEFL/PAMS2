<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payment Approval Management System || Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/feather.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>  
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
<style>
    .toggle-handle {
        background-color:white;
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
                                <li class="breadcrumb-item"><a href="/users">All Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="container py-md-4 mt-md-3">
                        <h6>Please fill in the following details</h6>
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if($users!=NULL)
                                    <form action="/users/{{md5($users->id)}}" method="post" name="new_user_form" id="new_user_form" onSubmit="return valid();">
                                        @csrf
                                        @method('PUT')
                                        <div class="contact_left_grid">
                                            <table width="100%" cellpadding="3" cellspacing="1">
                                                <tr>
                                                    <td colspan="2">
                                                        <label style="font-size: 16px;">Name: </label>	
                                                        <input type="text" name="name" value="{{$users->name}}" tabindex="1" required="true" class="form-control" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label style="font-size: 16px;padding-top: 20px;">Email: </label>	
                                                        <input type="text" name="email"  value="{{$users->email}}" tabindex="3" required="true" class="form-control" maxlength="100" pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label style="font-size: 16px;padding-top: 20px;">Centre: </label>
                                                        <select id="centre" name="centre" class="form-control" required="true" onChange="showDept();">
                                                            <option value="" disabled>Choose</option>
                                                            @foreach($centres as $centre) 
                                                                <option value="{{$centre->id}}" @if($centre->id == $users->centreID) selected @endif > {{$centre->CentreName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                                <tr id="usr_dept" @if($users->deptID=="11") style="display:none;" @endif>
                                                    <td colspan="2">
                                                        <label style="font-size: 16px;padding-top: 20px;">Department: </label>
                                                        <select id="dept" name="dept" class="form-control">
                                                            <option value="" disabled>Choose</option>
                                                            @foreach($depts as $dept)
                                                                <option value="{{$dept->id}}" @if($dept->id == $users->deptID) selected @endif> {{$dept->DeptName}} - {{$dept->DeptCode}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"> 
                                                        <label style="font-size: 16px;padding-top: 20px;">Role: </label>
                                                        <select class="form-control" name="role" required="true">
                                                            <option value="" disabled>Choose</option>
                                                            @foreach($roles as $role)
                                                                <option value="{{$role->id}}" @if($role->id == $users->roleID) selected @endif> {{$role->RoleName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label style="font-size: 16px;padding-top: 20px;">Status:</label> <br>
                                                        <input type="checkbox" name="status" id="status" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-width="100" @if($users->Status==1) checked @endif >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">
                                                        <label style="font-size: 16px;padding-top: 20px;">New Password: </label>	
                                                        <input name="newpassword" type="password" class="form-control"/>
                                                    </td>
                                                    <td width="50%">
                                                        <label style="font-size: 16px;padding-top: 20px;">Confirm Password: </label>	
                                                        <input name="confirmpassword" type="password" class="form-control"/> 
                                                    </td>
                                                </tr>
                                            </table>
                                            <p style="padding-top: 30px;text-align:center;">
                                                <button type="submit" class="btn btn-primary" name="submit" id="submit" style="background-color: #3396ff; border:none;">
                                                    <i class="fa fa-dot-circle-o"></i> Update
                                                </button>
                                            </p>
                                            <div class="clearfix"> </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @include('../layout/footer')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="{{ asset('js/off-canvas.js')}}"></script>
  <script src="{{ asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{ asset('js/template.js')}}"></script>
  
  <script src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
  <script src="{{ asset('js/select2.min.js')}}"></script>
<script>
    function valid(){
                
        if(document.new_user_form.newpassword.value ==""){
            return true;
        }
        else if(document.new_user_form.newpassword.value !== document.new_user_form.confirmpassword.value){
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
    if($('#centre').val()===1){
            $('#row_dept').show();
            $('#row_dept').removeAttr('display');   
            $('#dept').attr('required', '');
        }else{
            $('#row_dept').hide();
            $('#dept').removeAttr('required');   
        } 
    }

</script>
</body>
</html>