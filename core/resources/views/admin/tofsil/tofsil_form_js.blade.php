@section('script')
    <script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>
    @include('vendor.sweetalert2.sweetalert2_js')
    <script src="{{ asset('assets/admin/js/classification.js') }}"></script>
    <script>
        function getLsCase(data){
            var portId = $(data).val();
                $('#l_s_case_id').html('<option value="" selected>এল এ কেস নং  নির্বাচন করুন</option>');
                if (portId != '') {
                    $.ajax({
                        method: "POST",
                        url: "/admin/get_ls_case_no",
                        data: {
                            portId: portId,
                            "_token": "{{ csrf_token() }}"
                        },
                    }).done(function(data) {
                        $.each(data, function(index, item) {
                                $('#l_s_case_id').append('<option value="' + item.id +
                                    '">' + item.number + '</option>');
                        });
                    });
                }
        }
    </script>
@endsection
