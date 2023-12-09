@extends('admin.common.master')

@include('vendor.datatable.datatable_css')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">হোম</a></li>
                            <li class="breadcrumb-item active">সম্পদের স্টক (মজুদ)</li>
                        </ol>
                    </div>
                </div>
                <div class="text-center">
                    <h5>সম্পদের স্টক (মজুদ) তথ্য</h5>
                    <h6>স্থলবন্দরের নামঃ <span class="text-bold">{{ $product_stock->ports->port_name }}</span></h6>
                    <h6>টেন্ডারের ধরণঃ <span class="text-bold">{{ $tender_type }}</span></h6>
                    <h6>টেন্ডার নাম্বারঃ <span class="text-bold">{{ en_to_bn($product_stock->tender_number) }}</span></h6>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">

                @include('message.message')
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="fa-pull-left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list"></i> সম্পদের স্টক (মজুদ) তথ্য
                                    </h3>
                                </div>
                                <div class="fa-pull-right">
                                    <a href="{{ route('manage.product.stock') }}">
                                        <button class="btn btn-sm btn-info"><i class="fa fa-reply"></i> ফিরে যান সম্পদের স্টক (মজুদ)</button>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                    <tr>
                                        <th>ক্রমিক</th>
                                        <th>নাম</th>
                                        <th>স্টক (মজুদ)</th>
                                        <th>সম্পদের ধরণ</th>
                                        <th>মোট টাকা</th>
                                        <th>ক্রয়ের তারিখ</th>
                                        {{-- <th>অ্যাকশন</th> --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script-resource')
   @include('vendor.datatable.datatable_js')
   @include('vendor.sweetalert2.sweetalert2_js')
   <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
   <input type="hidden" name="product_stock_id" value="{{ $id }}">
   <script>
       $(function () {
           $('#list').DataTable({
               bAutoWidth: false,
               processing: true,
               serverSide: true,
               iDisplayLength: 10,
               ajax: {
                   url: "/admin/get_product_stock_details",
                   method: "POST",
                   data: function (d) {
                       d._token = $('input[name="_token"]').val();
                       d.product_stock_id = $('input[name="product_stock_id"]').val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                   {data: 'product_name', name: 'product_name'},
                   {data: 'stock', name: 'stock'},
                   {data: 'type', name: 'type'},
                   {data: 'price', name: 'price'},
                   {data: 'date', name: 'date'},
                //    {data: 'action', name: 'action', orderable: false, searchable: false},
               ],
               "aaSorting": []
           });
       });
       function deleteProductStock(id,e) {
           e.preventDefault();
           swal.fire({
               title: "আপনী কি নিশ্চিত?",
               text: "আপনি মুছে দিতে চান??!",
               icon: "warning",
               showCloseButton: true,
               // showDenyButton: true,
               showCancelButton: true,
               confirmButtonText: `মুছন `,
               cancelButtonText: `বাতিল  `,
               // dangerMode: true,
           }).then((result) => {
               if (result.value == true) {
                   swal.fire({
                       title: 'মুছে ফেলা হয়েছে!',
                       text: 'সফলভাবে মুছে ফেলা হয়েছে!',
                       icon: 'success'
                   }).then(function () {
                    location.reload();
                       $.ajax({
                           url: "/admin/delete_product_stock_details",
                           method: "POST",
                           data: {id: id, "_token": "{{ csrf_token() }}"},
                           dataType: 'json',
                           success: function () {
                               location.reload(true);
                           }
                       })
                   })
               } else if (result.value == false) {
                   swal.fire("বাতিল", "নিরাপদ :)", "error");
               }
           })
       }
   </script>
@endsection
