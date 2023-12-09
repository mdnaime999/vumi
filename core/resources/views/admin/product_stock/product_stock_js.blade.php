@section('script')
    <script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>
    @include('vendor.sweetalert2.sweetalert2_js')
    <script src="{{ asset('assets/common/select2/js/select2.min.js') }}"></script>
    <script>
        function hideProductForm(){
            $(".check_product_id").css("display", "none")
        }

        function searchUserStock() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var user_name = $('#user_name').val();
            var token = $('#token').val();
            if (user_name) {
                $('.search_item').show();
            } else {
                $('.search_item').hide();
            }
            $.ajax({
                url: "/admin/search_user_stock_info",
                type: "POST",
                data: {
                    user_name: user_name,
                    _token: token
                },
                success: function(data) {
                    if (data) {
                        $('.search_item').html(data);
                    }
                }
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>

    {{-- <script>
        function getWarrantyType(value){
            if (value == 1) {
                $(".without_warranty").css("display", "none");
                $(".with_purchase_date").css("display", "block");
                $(".with_warranty_date").css("display", "block");
                $(".without_warranty_button").css("display", "none");
                $(".with_warranty_button").css("display", "block");
            } else if(value == 2) {
                $(".without_warranty").css("display", "block");
                $(".with_purchase_date").css("display", "none");
                $(".with_warranty_date").css("display", "none");
                $(".without_warranty_button").css("display", "block");
                $(".with_warranty_button").css("display", "none");
            } else {
                $(".without_warranty").css("display", "block");
                $(".with_purchase_date").css("display", "none");
                $(".with_warranty_date").css("display", "none");
                $(".without_warranty_button").css("display", "block");
                $(".with_warranty_button").css("display", "none");
            }
        }

        function addProductStockWarrantyContent() {
            let sl = parseInt($("#product_stock_id").attr('data-attr')) + 1;
            let div_item =
                '<div class="row">' +
                    '<div class="col-md-3">' +
                        '<div class="form-group">' +
                            '<label> সম্পদের নাম <span class="text-danger">*</span></label>' +
                            '<input type="text" class="form-control" name="name[]" placeholder="পেন্সিল" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label> সম্পদের সংখ্যা <span class="text-danger">*</span></label>' +
                            '<input type="text" class="form-control" name="stock[]" placeholder="১০" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label> সম্পদের ধরণ </label>' +
                            '<select class="form-control" name="type[]" autofocus>' +
                                '<option value="5">সংখ্যা</option>' +
                                '<option value="1">প্যাঃ</option>' +
                                '<option value="2">বক্স</option>' +
                                '<option value="3">রোল</option>' +
                                '<option value="4">বোতল</option>' +
                            '</select>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label> সম্পদের মূল্য </label>' +
                            '<input type="text" class="form-control" name="price[]" placeholder="সংখ্যা" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-1">' +
                        '<div class="form-group">' +
                            '<label> কেনার তারিখ </label>' +
                            '<input type="date" class="form-control" name="date[]" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-1">' +
                        '<div class="form-group">' +
                            '<label> ওয়ারেন্টি তারিখ </label>' +
                            '<input type="date" class="form-control" name="warranty_date[]" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-1 mt-4">' +
                        '<button class="btn btn-danger" type="button" onclick="deleteProductStockContent(this)">' + '<i class="fa fa-trash"></i>' + '</button>'
                    '</div>' +
                '</div>';
            $("#product_stock_id").append(div_item);
            $("#product_stock_id").attr('data-attr', sl);
        }
        function addProductStockContent() {
            let sl = parseInt($("#product_stock_id").attr('data-attr')) + 1;
            let div_item =
                '<div class="row">' +
                    '<div class="col-md-3">' +
                        '<div class="form-group">' +
                            '<label> সম্পদের নাম <span class="text-danger">*</span></label>' +
                            '<input type="text" class="form-control" name="name[]" placeholder="পেন্সিল" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label> সম্পদের সংখ্যা <span class="text-danger">*</span></label>' +
                            '<input type="text" class="form-control" name="stock[]" placeholder="১০" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label> সম্পদের ধরণ </label>' +
                            '<select class="form-control" name="type[]" autofocus>' +
                                '<option value="5">সংখ্যা</option>' +
                                '<option value="1">প্যাঃ</option>' +
                                '<option value="2">বক্স</option>' +
                                '<option value="3">রোল</option>' +
                                '<option value="4">বোতল</option>' +
                            '</select>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label> সম্পদের মূল্য </label>' +
                            '<input type="text" class="form-control" name="price[]" placeholder="সংখ্যা" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label> কেনার তারিখ </label>' +
                            '<input type="date" class="form-control" name="date2[]" autofocus>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-1 mt-4">' +
                        '<button class="btn btn-danger" type="button" onclick="deleteProductStockContent(this)">' + '<i class="fa fa-trash"></i>' + '</button>'
                    '</div>' +
                '</div>';
            $("#product_stock_id").append(div_item);
            $("#product_stock_id").attr('data-attr', sl);
        }
        function deleteProductStockContent(data) {
            $(data).parent().parent().remove();
        }
    </script> --}}
@endsection
