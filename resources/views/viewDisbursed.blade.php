<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Payment Approval Management System || View Disbursed Application Request</title>
        <script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/feather.css')}}">
        <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
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
                        <div class="row">
                            <div class="col-lg-12 stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 >View Disbursed Application Request</h3>
                                        <div class="table-responsive pt-3">
                                            @if($applications != NULL) 
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th colspan="6" style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">Application Number: {{$applications->ApplicationNumber}}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Name</th>
                                                        <td>{{$applications->user->name}}</td>
                                                        <th>Email</th>
                                                        <td>{{$applications->user->email}}</td>
                                                        <th>Centre</th>
                                                        <td>@if($applications->user->deptID!=11) {{$applications->user->centre->CentreName}} − {{$applications->user->dept->DeptCode}} @else {{$applications->user->centre->CentreName}} @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Item Type</th>
                                                        <td>{{$applications->type->typeName}}</td>
                                                        <th>Uploaded Document</th>
                                                        <td style="text-align: center;" colspan="3"><a href="{{$applications->file}}"  width="100" height="100" target="_blank"> <strong style="color: red">View Document</strong></a></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Expected Amount</th>
                                                        <td>{{$applications->currency->currencyName}} {{$applications->expectedAmount}}</td>
                                                        <th>Status</th>
                                                        <td colspan="3"> 
                                                            @if($applications->status=="")
                                                                Not Response Yet
                                                            @elseif($applications->status=="Withdrawn")
                                                                Withdrawn
                                                            @elseif($applications->status=="Completed")
                                                                Approved by Finance
                                                            @elseif($applications->status=="Rejected")
                                                                Rejected by {{$applications->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName}}
                                                            @elseif($applications->status=="Approved")
                                                                Approved by {{$applications->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName}}
                                                            @elseif($applications->status=="Approved-Pending Docs")
                                                                Approved-Pending Docs by {{$applications->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName}}
                                                            @elseif($applications->status=="Requiring Attention")
                                                                Requiring Attention by {{$applications->applicationTracking->sortByDesc('updated_at')->first()->approver->role->RoleName}}
                                                            @else
                                                                Error 404
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Date of Application</th>
                                                        <td>
                                                            {{date('h:i:s A', strtotime($applications->created_at))}}
                                                            <br>
                                                            {{date('d-m-Y', strtotime($applications->created_at))}}
                                                        </td>
                                                        <th>Remark</th>                 
                                                        <td colspan="4">{{$applications->remark}}</td>  
                                                    </tr>
                                                </table>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th colspan="6" style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">Disbursed Amount Info</th>
                                                    </tr>
                                                @if($applications->disbursedAmount!="")
                                                    <tr>
                                                        <th>Amount of Disbursed</th>
                                                        <td>{{$applications->currency->currencyName." ".$applications->disbursedAmount}}</td>
                                                        <th>Date of Dibursement</th>
                                                        <td>{{date('h:i:s A d-m-y', strtotime($applications->updated_at))}}</td>
                                                    </tr>
                                                @else
                                                    <tr>                  
                                                        <td  colspan="4" style="font-size: 20px;text-align: center;color: red">Not Updated Yet</td>
                                                    </tr>
                                                @endif
                                                </table>
                                                @if(!$applicationTrack->isEmpty())
                                                    <?php $att = 0; ?>
                                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <tr align="center">
                                                            <th colspan="100%" style="color: blue;font-weight: bold;font-size: 20px;text-align: center;">Tracking History</th> 
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="container py-4">
                                                                    @foreach($applicationTrack as $track)
                                                                    <?php
                                                                        if($track->ApproverID == $user->id){
                                                                            $bol = true;
                                                                        }

                                                                        if($track->attention == 1){
                                                                            $att = 1;
                                                                        }
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-auto text-center flex-column d-none d-sm-flex">
                                                                            @if($loop->first)
                                                                                <div class="row h-50">
                                                                                    <div class="col">&nbsp;</div>
                                                                                    <div class="col">&nbsp;</div>
                                                                                </div>
                                                                                <h5 class="m-2">
                                                                                    @if ($track->status == "Approved")
                                                                                        <span class="badge rounded-pill bg-success border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                    @elseif($track->status == "Approved-Pending Docs")
                                                                                        <span class="badge rounded-pill bg-light border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                    @elseif($track->status == "Rejected")
                                                                                        <span class="badge rounded-pill bg-danger border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                    @elseif($track->status == "Requiring Attention")
                                                                                        @if($att==1 && $applications->status=="Requiring Attention")
                                                                                            <span class="badge rounded-pill bg-warning border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                        @else
                                                                                            <span class="badge rounded-pill bg-light border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                        @endif
                                                                                    @endif
                                                                                </h5>
                                                                                @if($loop->last)
                                                                                    <div class="row h-50">
                                                                                        <div class="col">&nbsp;</div>
                                                                                        <div class="col">&nbsp;</div>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="row h-50">
                                                                                        <div class="col border-end order border-dark">&nbsp;</div>
                                                                                        <div class="col">&nbsp;</div>
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                <div class="row h-50">
                                                                                    <div class="col border-end border-dark">&nbsp;</div>
                                                                                    <div class="col">&nbsp;</div>
                                                                                </div>
                                                                                <h5 class="m-2">
                                                                                    @if ($track->status == "Approved")
                                                                                        <span class="badge rounded-pill bg-success border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                    @elseif($track->status == "Approved-Pending Docs")
                                                                                        <span class="badge rounded-pill bg-light border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                    @elseif($track->status == "Rejected")
                                                                                        <span class="badge rounded-pill bg-danger border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                    @elseif($track->status == "Requiring Attention")
                                                                                        @if($att==1 && $applications->status=="Requiring Attention")
                                                                                            <span class="badge rounded-pill bg-warning border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                        @else
                                                                                            <span class="badge rounded-pill bg-light border border-dark">&nbsp;&nbsp;&nbsp;</span>
                                                                                        @endif
                                                                                    @endif
                                                                                </h5>
                                                                                
                                                                                @if($loop->last)
                                                                                    <div class="row h-50">
                                                                                        <div class="col">&nbsp;</div>
                                                                                        <div class="col">&nbsp;</div>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="row h-50">
                                                                                        <div class="col border-end border-dark">&nbsp;</div>
                                                                                        <div class="col">&nbsp;</div>
                                                                                    </div>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                        <!-- timeline details -->
                                                                        <div class="col py-2">
                                                                            <div class="card w-75 border-dark">
                                                                                <div class="card-header py-1 d-flex flex-row justify-content-between align-items-center">
                                                                                    @if ($track->status == "Approved")
                                                                                        <span class="badge rounded-pill bg-success fs-6 my-1">{{$track->status}}</span>
                                                                                    @elseif($track->status == "Approved-Pending Docs")
                                                                                        <span class="badge rounded-pill bg-secondary text-dark fs-6 my-1">{{$track->status}}</span>
                                                                                    @elseif($track->status == "Rejected")
                                                                                        <span class="badge rounded-pill bg-danger fs-6 my-1">{{$track->status}}</span>
                                                                                    @elseif($track->status == "Requiring Attention")
                                                                                        @if($att==1 && $applications->status=="Requiring Attention")
                                                                                            <span class="badge rounded-pill bg-warning text-dark fs-6 my-1">{{$track->status}}</span>
                                                                                        @else
                                                                                            <span class="badge rounded-pill bg-light text-dark fs-6 my-1">No Response Yet</span>
                                                                                        @endif
                                                                                    @endif
                                                                                    <div class="align-items-center text-muted fs-6">{{date('l, F j Y g:i a', strtotime($track->updated_at))}}</div>
                                                                                </div>
                                                                                <div class="card-body py-2">
                                                                                    <h4 class="card-title text-muted ">
                                                                                        {{$track->approver->name}}
                                                                                    </h4>
                                                                                    <p class="card-text text-dark">{{$track->remark}}</p>
                                                                                </div>
                                                                                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                                                                                    @if($track->fileUpload!='')
                                                                                        <a href="{{$track->fileUpload}}" width="100" height="100" target="_blank" class="card-text"> <strong style="color: red">View Document</strong></a>
                                                                                    @endif

                                                                                    @if(($track->status=="Approved-Pending Docs" && $track->ApproverID==$user->id) || ($track->status=="Requiring Attention" && $track->ApproverID==$user->id && $applications->status == "Approved"))
                                                                                        <div class="text-center">
                                                                                            <button class="btn btn-rounded btn-primary btn-sm" data-toggle="modal" data-target="#myModalUpdate">Update</button>
                                                                                        </div>
                                                                                        <div class="modal fade" id="myModalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg" role="document">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                    <form id="confirmform" action="/applications/{{$applications->id}}/updateTrack/{{$track->id}}/disbursed" method="post" name="submit" enctype="multipart/form-data" onsubmit="return submitUpdate(this);">
                                                                                                        @csrf
                                                                                                        @method('PUT')
                                                                                                        <div class="modal-body">
                                                                                                            <table class="table table-bordered table-hover data-tables">
                                                                                                                <tr>
                                                                                                                    <th>Status :</th>
                                                                                                                    <td>
                                                                                                                    <select name="status" id="status" class="form-control wd-450" 
                                                                                                                        <?php 
                                                                                                                        if($track->status=="Approved-Pending Docs"){
                                                                                                                            echo('style="font-weight:bold;color:black;background-color:white;"'); 
                                                                                                                        }elseif($track->status == "Approved"){
                                                                                                                            echo('style="font-weight:bold;color:black;background-color:#80f27e;"');
                                                                                                                        }elseif($track->status == "Rejected"){
                                                                                                                            echo('style="font-weight:bold;color:black;background-color:#ffa8a8"');
                                                                                                                        }elseif($track->status == "Requiring Attention"){
                                                                                                                            echo('style="font-weight:bold;color:black;background-color:yellow;color:black"'); 
                                                                                                                        }?>
                                                                                                                        required="true" onchange="selectColor(this.value)">
                                                                                                                        <option value="" style="background-color:white;" selected disabled>Please Choose</option>
                                                                                                                        @if ($applications->status=="Approved-Pending Docs") 
                                                                                                                            <option value="Approved-Pending Docs"style="background-color:white" @if($track->status == "Approved-Pending Docs") selected @endif>Approved - Pending Documentation</option>
                                                                                                                        @else
                                                                                                                            <option value="Approved" style="background-color:#80f27e;" @if($track->status == "Approved") selected @endif>Approved</option>
                                                                                                                        @endif
                                                                                                                        <option value="Rejected" style="background-color:#ffa8a8" @if($track->status == "Rejected") selected @endif>Rejected</option>
                                                                                                                        <option value="Requiring Attention" style="background-color:yellow;color:black" @if($track->status == "Requiring Attention") selected @endif>Requiring Attention</option>
                                                                                                                    </select>
                                                                                                                    </td>
                                                                                                                </tr>  
                                                                                                                <tr>
                                                                                                                    <th>Expected Amount :</th>
                                                                                                                    <td>
                                                                                                                    <div class="input-group">
                                                                                                                        <span class="input-group-text" id="basic-addon1">{{$applications->currency->currencyName}}</span>
                                                                                                                        <input type="number" value="{{$applications->expectedAmount}}" step="0.01" disabled class="form-control">
                                                                                                                    </div>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <th>Disbursed Amount :</th>
                                                                                                                    <td >
                                                                                                                    <div class="input-group">
                                                                                                                        <span class="input-group-text" id="basic-addon1">{{$applications->currency->currencyName}}</span>
                                                                                                                        <input type="number" id="lmd" name="lmd" placeholder="Disbursed Amount" step="0.01" min="0" class="form-control" @if($applications->disbursedAmount!="") value="{{$applications->disbursedAmount}}" @endif >
                                                                                                                    </div>
                                                                                                                    </td>
                                                                                                                </tr> 
                                                                                                                <tr>
                                                                                                                    <th>Remark :</th>
                                                                                                                    <td>
                                                                                                                    <textarea name="remark" placeholder="Remark" rows="12" cols="14" class="form-control wd-450" required="true">{{$track->remark}}</textarea></td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                                                                        </div>
                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div> 
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                @endif
                                                
                                                @if(($applications->nextApp == $user->roleID || ($user->deptID == "8" && $applications->nextApp == "7")) && $applications->applicationTracking->where('ApproverID', $user->id)->first()==NULL)
                                                    <p align="center"  style="padding-top: 20px">                            
                                                        <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Take Action</button>
                                                    </p>  
                                                @endif    
                                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id='confirmform' method="post" name="submit" action="" onsubmit="return submitResult(this);">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <table class="table table-bordered table-hover data-tables">
                                                                    <tr>
                                                                        <th>Status :</th>
                                                                        <td>
                                                                        <select name="status" id="status" class="form-control wd-450" style="font-weight:bold;color:black;" required="true" onchange="selectColor(this.value)">
                                                                            <option value="" style="background-color:white;" selected disabled>Please Choose</option>
                                                                            @if ($applications->status=="Approved-Pending Docs") 
                                                                                <option value="Approved-Pending Docs"style="background-color:white">Approved - Pending Documentation</option>
                                                                            @else
                                                                                <option value="Approved" style="background-color:#80f27e;">Approved</option>
                                                                            @endif
                                                                            <option value="Rejected" style="background-color:#ffa8a8">Rejected</option>
                                                                            <option value="Requiring Attention" style="background-color:yellow;color:black">Requiring Attention</option>
                                                                        </select>
                                                                        </td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <th>Expected Amount :</th>
                                                                        <td>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" id="basic-addon1">{{$applications->currency->currencyName}}</span>
                                                                            <input type="number" value="{{$applications->expectedAmount}}" step="0.01" disabled class="form-control">
                                                                        </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Disbursed Amount :</th>
                                                                        <td >
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" id="basic-addon1">{{$applications->currency->currencyName}}</span>
                                                                            <input type="number" id="lmd" name="lmd" placeholder="Disbursed Amount" step="0.01" min="0" class="form-control" @if($applications->disbursedAmount!="") {{$applications->disbursedAmount}} @endif >
                                                                        </div>
                                                                        </td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <th>Remark :</th>
                                                                        <td>
                                                                        <textarea name="remark" placeholder="Remark" rows="12" cols="14" class="form-control wd-450" required="true"></textarea></td>
                                                                    </tr> 
                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('../layout/footer')
                </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        function selectColor(value){
            switch(value) {
                case "Approved":
                    document.getElementById('status').style.backgroundColor='#80f27e';
                    document.getElementById('lmd').required=true;
                    document.getElementById('lmd').disabled=false;
                break;
                case "Rejected":
                    document.getElementById('status').style.backgroundColor='#ffa8a8';
                    document.getElementById('lmd').required=false;
                    document.getElementById('lmd').disabled=true;
                break;
                case "Requiring Attention":
                    document.getElementById('status').style.backgroundColor='yellow';
                    document.getElementById('status').style.color='black';
                    document.getElementById('lmd').required=false;
                    document.getElementById('lmd').disabled=true;
                break;
                case "Approved-Pending Docs":
                    document.getElementById('status').style.backgroundColor='white';
                    document.getElementById('lmd').required=true;
                    document.getElementById('lmd').disabled=false;
                break;
                default:
                document.getElementById('status').style.backgroundColor='white';
                break;
            }
        }

        function submitResult(form) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'Are you sure want to submit application?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if(result.isConfirmed) {
                const submitFormFunction = Object.getPrototypeOf(form).submit;
                submitFormFunction.call(form);
            }else if(result.isCancel){
                Swal.fire('Application not submitted', '', 'info')
            }
        });
        return false;
        }
    </script>
    <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('js/off-canvas.js')}}"></script>
    <script src="{{asset('js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('js/template.js')}}"></script>
    </body>

</html>