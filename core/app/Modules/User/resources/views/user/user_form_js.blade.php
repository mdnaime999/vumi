@section('script-resource')
<script src="{{asset('assets/admin/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('core/app/modules/user/js/user.js')}}"></script>
@include('vendor.sweetalert2.sweetalert2_js')
<script src="{{ asset('assets/common/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endsection
