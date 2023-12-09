@include('admin.common.topbar')
@include('admin.common.side_menu')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_base_url" content="{{ url('/') }}">
    <title> ভূমি রেকর্ড ও জরিপ অধিদপ্তর  | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/admin/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/admin.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('assets/common/bootstrap/css/bootstrap.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('assets/admin/images/logo.png')}}" type="image/x-icon"/>
    <link href="https://fonts.maateen.me/kalpurush/font.css" rel="stylesheet">
    @yield('header-resource')
    @yield('header-resource1')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
   @yield('topbar')
   @yield('sidebar')
    @yield('breadcumb')
   @yield('content')

    <!-- Main Sidebar Container -->

    <!-- /.content-wrapper -->
    <footer class="main-footer" style="text-align: center"><strong>Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} <a href="javascript:void(0);">Timerni</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>

    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('assets/common/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/common/jquery-ui/jquery-ui.min.js')}}"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button)

</script>

<script src="{{asset('assets/common/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('assets/common/jquery-knob/jquery.knob.min.js')}}"></script>

<script src="{{asset('assets/common/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/admin/js/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/admin/js/adminlte.js')}}"></script>
@yield('script-resource')
@yield('script')
</body>
</html>
