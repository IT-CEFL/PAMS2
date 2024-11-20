<!DOCTYPE HTML>
<html lang="zxx">
    <head>
        <title>Payment Approval Management System || Application Form</title>

        <script>
            addEventListener("load", function () {
                    setTimeout(hideURLbar, 0);
            }, false);

            function hideURLbar() {
                    window.scrollTo(0, 1);
            }
        </script>
        <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/feather.css')}}">
        <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

        <link rel="stylesheet" href="{{asset('css/flag-icon.min.css')}}"/>
        <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/fontawesome-stars-o.css')}}">
        <link rel="stylesheet" href="{{asset('css/fontawesome-stars.css')}}">

        <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
        <!-- body -->
        <link href="//fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
        <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>  
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
    </head>

    <body>
        <div class="container-scroller">	
            @include('../layout/header')
            <div class="container-fluid page-body-wrapper">
                @include('../layout/sidebar')
                <div class="main-panel">
                    <div class="content-wrapper">
                        <h6>Please Fill the Following Details</h6>
                        <form method="post" action="/applications" id='confirmform' enctype="multipart/form-data" onsubmit="return submitResult(this);">
                            @csrf
                            @method('POST')
                            <label style="font-size: 18px;">Name:</label>	
                            <input value="{{$user->name}}" name="name" type="text" tabindex="1" required='true' class="form-control" readonly>
                            <label style="font-size: 18px;padding-top: 20px;">Email:</label>	
                            <input type="text" name="email" tabindex="3" required='true' class="form-control" maxlength="10" value="{{$user->email}}" readonly>
                            
                            <label style="font-size: 18px;padding-top: 20px;">Upload (PDF,ZIP,RAR,7ZIP)<span style="color: #F32205;">*</span>:</label>
                            <input type="file" name="attachFile" required="true" class="form-control" accept="application/pdf,.zip,.rar,.7zip">

                            <label style="font-size: 18px;padding-top: 20px;">Item Type<span style="color: #F32205;">*</span>:</label>
                            <select class="form-control" name="itemType" required="true">
                                <option value="" selected disabled>Please Choose</option>
                                @foreach($types as $itemType)
                                    <option value="{{$itemType->id}}">{{$itemType->typeName}}</option>
                                @endforeach
                            </select>
                            <label style="font-size: 18px;padding-top: 20px;">Currency<span style="color: #F32205;">*</span>:</label>
                            <select class="form-control" name="currency" required="true">
                                <option value="" selected disabled>Please Choose</option>
                                @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}">{{$currency->currencyName}}</option>
                                @endforeach
                            </select>


                                <label style="font-size: 18px;padding-top: 20px;">Expected Amount<span style="color: #F32205;">*</span>:</label><br>
                                <input type="number" class="form-control" id="explamt" name="explamt" value="" required="true" step="0.01" min="0"/><br>
                                
                                <label style="font-size: 18px;padding-top: 20px;">Message/Comment:</label>
                                <textarea class="form-control" name="msgcmt" value="" rows="4" cols="50"></textarea>
                            
                                <p style="padding-top: 30px;">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    <input type="reset" value="Clear" class="btn btn-danger">
                                </p>
                                <div class="clearfix"> </div>
                            </div>
                        </form>
                        @include('../layout/footer')
                    </div>
                </div>
            </div>
        </div>
        <script>
            
        function submitResult(form) {
            // form.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Are you sure want to submit application?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    const submitFormFunction = Object.getPrototypeOf(form).submit;
                    submitFormFunction.call(form);
                }else if(result.isCancel){
                    Swal.fire('Application not submitted', '', 'info')
                }
            });
            return false;
        }
            
        </script>
        <!-- js-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
        $('#explamt').on('blur', function(){
            const v = $(this).val();
            if(isNaN(v) || v === "")//this line may need amending depending on validation
                return false;

            $(this).val(parseFloat(v).toFixed(2));
        });
        $('input.CurrencyInput').on('blur', function() {
        const value = this.value.replace(/,/g, '');
        this.value = parseFloat(value).toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigits: 2,
            minimumFractionDigits: 2
        });
        });


        </script>

        <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
        <script src="{{asset('js/off-canvas.js')}}"></script>
        <script src="{{asset('js/hoverable-collapse.js')}}"></script>
        <script src="{{asset('js/template.js')}}"></script>
        <script src="{{asset('js/Chart.min.js')}}"></script>
        <script src="{{asset('js/dashboard.js')}}"></script>
        <script src="{{asset('js/jquery.barrating.min.js')}}"></script>
    </body>
</html>
