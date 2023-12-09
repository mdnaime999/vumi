@section('script')
    <script src="{{ asset('assets/common/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });

        function getDesignationForRole(value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var department_id = value;
        $.ajax({
            url: "/admin/get_designation_for_role_transfer",
            type: "POST",
            data: {
                department_id: department_id,
            },
            success: function(data) {
                if (data) {
                    $('.designation_id').html(data);
                }
            }
        });
    }
    </script>
@endsection
