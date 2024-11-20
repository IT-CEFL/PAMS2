<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div align="center">
    <table class="table table-borderless" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border:none;">
        <tbody>
            <tr>
                <td style="padding:18.75pt 0in 18.75pt 0in">
                    <p align="center" style="text-align:center">
                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                            <b>
                                <span style="font-size:14.5pt;color:#BBBFC3">Cambridge English For Life Sdn Bhd </span>
                            </b>
                        </span>
                    </p>
                </td>
            </tr>
            <!-- Email Body -->
            <div align="center">
                <p align="center" style="text-align:center">
                    <tr>
                        <td width="100%" style="width:100.0%;border-top:solid #EDEFF2 1.0pt; border-left:none;border-bottom:solid #EDEFF2 1.0pt;border-right:none; background:white;padding:0in 0in 0in 0in">
                            <div align="center">
                                <table class="table table-borderless" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                                    <tbody>
                                        <tr>
                                            <td style="padding:26.25pt 26.25pt 26.25pt 26.25pt">
                                                <h4>
                                                    <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                        Payment Approval Request [@if($application->user->centreID != "1"){{$application->user->centre->CentreName}} @else {{$application->user->centre->CentreName}} - {{$application->user->dept->DeptCode}} @endif]
                                                    </span>
                                                </h4>
                                                <table class="table table-borderless" border="0" cellpadding="0" width="100%" style="width:100.0%; box-sizing: border-box; border:none;">
                                                    <tbody>
                                                        <tr>
                                                            <td width="20%" style="width:10.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                                            Requested By
                                                                        </span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td width="2%" style="width:2.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">:</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td style="padding:4.75pt .75pt 4.75pt .75pt;box-sizing: border-box">
                                                                <p>
                                                                    <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                                        {{$application->user->name}}
                                                                    </span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%" style="width:10.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Item Type</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td width="2%" style="width:2.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">:</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td style="padding:4.75pt .75pt 4.75pt .75pt;box-sizing: border-box">
                                                                <p>
                                                                    <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                                        {{$application->type->typeName}}
                                                                    </span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%" style="width:10.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Application Number</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td width="2%" style="width:2.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">:</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td style="padding:4.75pt .75pt 4.75pt .75pt;box-sizing: border-box">
                                                                <p>
                                                                    <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                                        {{$application->applicationNumber}}
                                                                    </span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%" style="width:10.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Expected Amount</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td width="2%" style="width:2.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">:</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td style="padding:4.75pt .75pt 4.75pt .75pt;box-sizing: border-box">
                                                                <p>
                                                                    <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                                        {{$application->currency->currencyName}} {{$application->expectedAmount}}
                                                                    </span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%" style="width:10.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Requested Date</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td width="2%" style="width:2.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">:</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td style="padding:4.75pt .75pt 4.75pt .75pt;box-sizing: border-box">
                                                                <p>
                                                                    <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                                        {{date('l jS \of F Y h:i:s A', strtotime($application->created_at))}}
                                                                    </span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%" style="width:10.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Status</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td width="2%" style="width:2.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">:</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td style="padding:4.75pt .75pt 4.75pt .75pt;box-sizing: border-box">
                                                                <p>
                                                                    <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                                        @if($application->status == NULL) Not Updated Yet @else {{$application->status}} @endif
                                                                    </span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        @if(!$application->applicationTracking->isEmpty())
                                                        <?php                                                            
                                                            $applicationTracking = $application->applicationTracking->filter(function($value, $key) {
                                                                                    if($value['status'] == 'Approved' || $value['status'] == 'Approved-Pending Docs') {
                                                                                        return $value;
                                                                                    }})->sortBy('updated_at');
                                                        ?>
                                                            <tr>
                                                                <td width="10%" style="width:10.0%;padding:4.75pt .75pt 4.75pt .75pt" class="align-top">
                                                                    <p align="center" style="text-align:center">
                                                                        <b>
                                                                            <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Approver</span>
                                                                        </b>
                                                                    </p>
                                                                </td>
                                                                <td width="2%" style="width:2.0%;padding:4.75pt .75pt 4.75pt .75pt" class="align-top">
                                                                    <p align="center" style="text-align:center">
                                                                        <b>
                                                                            <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">:</span>
                                                                        </b>
                                                                    </p>
                                                                </td>
                                                                <td style="padding:4.75pt .75pt 4.75pt .75pt;box-sizing: border-box">
                                                                    <p>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                                            @foreach($applicationTracking as $track)
                                                                                @if(!$loop->first)<br>@endif {{$loop->iteration}}. {{$track->approver->name}} <br>
                                                                            @endforeach
                                                                        </span>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <td width="10%" style="width:10.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Remarks</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td width="2%" style="width:2.0%;padding:4.75pt .75pt 4.75pt .75pt">
                                                                <p align="center" style="text-align:center">
                                                                    <b>
                                                                        <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">:</span>
                                                                    </b>
                                                                </p>
                                                            </td>
                                                            <td style="padding:4.75pt .75pt 4.75pt .75pt;box-sizing: border-box">
                                                                <p>
                                                                    <span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
                                                                        {{$application->remark}}
                                                                    </span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </p>
            </div>
            <tr>
                <td style="padding:0in 0in 0in 0in">
                    <div align="center">
                        <table class="table table-borderless" border="0" cellspacing="0" cellpadding="0" width="570" style="width:427.5pt; border:none;">
                            <tbody>
                                <tr>
                                    <td style="padding:26.25pt 26.25pt 26.25pt 26.25pt">
                                        <p align="center" style="margin-top:0in;text-align:center;line-height:18.0pt">
                                            <span style="font-size:9.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#AEAEAE">
                                                © 2023 Cambridge English For Life Sdn Bhd. All rights reserved.
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                     </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<p><br></p> 