{!! Session::has('success') ? '<div style="padding:.5rem!important;background:#0b90a5 !important; color: #fff !important;" class="alert alert-success alert-dismissible">
       <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'. Session::get("success") .'</div>' : '' !!}
{!! Session::has('error') ? '<div class="alert alert-danger alert-dismissible" style="padding:.5rem!important;font-size:14px;">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'. Session::get("error") .'</div>' : '' !!}
