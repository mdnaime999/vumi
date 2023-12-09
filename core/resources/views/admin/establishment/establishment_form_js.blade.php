@section('script')
    <script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>
    @include('vendor.sweetalert2.sweetalert2_js')
    <script src="{{ asset('assets/admin/js/classification.js') }}"></script>
    <script src="{{ asset('assets/admin/ckeditor/ckeditor.js') }}"></script>
@endsection
