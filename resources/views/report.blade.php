<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/vendor.bundle.base.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/feather.css')}}">
        <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

        <link rel="stylesheet" href="{{asset('css/flag-icon.min.css')}}"/>
        <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/fontawesome-stars-o.css')}}">
        <link rel="stylesheet" href="{{asset('css/fontawesome-stars.css')}}">
        
        <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather.css')}}">
  <link rel="stylesheet" href="{{asset('css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/select2-bootstrap.min.css')}}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/gridphp/themes/cupertino/jquery-ui.custom.css') }}"></link>
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/gridphp/jqgrid/css/ui.jqgrid.bs.css') }}"></link>

	<script src="{{ asset('assets/gridphp/jquery.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/gridphp/jqgrid/js/i18n/grid.locale-en.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/gridphp/jqgrid/js/jquery.jqGrid.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/gridphp/themes/jquery-ui.custom.min.js') }}" type="text/javascript"></script>

	<!-- CSRF Token for Ajax calls -->
        <script type="text/javascript">
                jQuery.ajaxSetup({headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}});
        </script>        

	<link rel="stylesheet" type="text/css" media="screen" href="//cdn.jsdelivr.net/gh/tamble/jquery-ui-daterangepicker@0.5.0/jquery.comiseo.daterangepicker.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js" type="text/javascript"></script>
	<script src="//cdn.jsdelivr.net/gh/tamble/jquery-ui-daterangepicker@0.5.0/jquery.comiseo.daterangepicker.min.js" type="text/javascript"></script>
    <style>
        .ui-jqgrid-title{
            font-weight: bold !important;
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
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h3><b>Reports</b></h3>
                                    <div class="container-fluid">
                                        <div>{!! $grid !!}</div>
                                        <br>
                                        <div>{!! $grid2 !!}</div>
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
    <!-- <script src="{{asset('js/off-canvas.js')}}"></script>
    <script src="{{asset('js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('js/template.js')}}"></script>
    <script src="{{asset('js/Chart.min.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script> -->
    <!-- <script src="{{asset('js/jquery.barrating.min.js')}}"></script> -->
</body>
</html> 