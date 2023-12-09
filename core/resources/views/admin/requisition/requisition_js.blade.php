@section('script-resource')
    <script src="{{asset('assets/admin/js/jquery.validate.min.js')}}"></script>
    @include('vendor.sweetalert2.sweetalert2_js')
    <script src="{{ asset('assets/common/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>

    <script>
        function addRequisitionContent() {
            let sl = parseInt($("#requisition_details").attr('data-attr')) + 1;
            let div_item =
                '<div class="row">' +
                    '<div class="col-md-4">' +
                        '<div class="form-group">' +
                            '<label>মালামালের বিবরণ <span class="text-danger">*</span></label>' +
                            '<select name="product_id[]" class="form-control select2" autofocus>' +
                                '<option value="" disabled selected>পণ্য সিলেক্ট করুন</option>' +
                                '@foreach ($products as $product)' +
                                    '<option value="{{ $product->id }}">{{ $product->name }}</option>' +
                                '@endforeach' +
                            '</select>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label>চাহিদার পরিমাণ <span class="text-danger">*</span></label>' +
                            '<input type="text" class="form-control" name="product_need[]" value="" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label>ইতিপূর্বে সরঃ তারিখ </label>' +
                            '<input type="date" class="form-control" name="previous_date[]" value="" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                        '<div class="form-group">' +
                            '<label>মন্তব্য </label>' +
                            '<input type="text" class="form-control" name="comment[]" value="" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-1 mt-4">' +
                        '<button class="btn btn-danger" type="button" onclick="deleteRequisitionContent(this)">' + '<i class="fa fa-trash"></i>' + '</button>'
                    '</div>' +
                '</div>';
            $("#requisition_details").append(div_item);
            $("#requisition_details").attr('data-attr', sl);
        }
        function deleteRequisitionContent(data) {
            $(data).parent().parent().remove();
        }

        function getProductStock(value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var tender_id = value;
            $.ajax({
                url: "/admin/get_product_stock_items",
                type: "POST",
                data: {
                    tender_id: tender_id,
                },
                success: function(data) {
                    if (data) {
                        $('.product_id').html(data);
                    }
                }
            });
        }
    </script>
@endsection
