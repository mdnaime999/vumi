@extends('admin.common.master')

@include('vendor.datatable.datatable_css')

@section('content')
<?php
    use Illuminate\Support\Facades\Auth;
    $access = config('global.access') ? config('global.access') : [];
    $checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false
?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">সম্পদের স্টক (মজুদ)</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">হোম</a></li>
                            <li class="breadcrumb-item active">সম্পদের স্টক (মজুদ)</li>
                        </ol>
                    </div>
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
                                <div class="fa-pull-right @if(array_search("admin/add/product/stock", $access) > -1 || $checkAdmin) @else d-none @endif">
                                    <a class="" href="{{ route('add.product.stock') }}">
                                        <button class="btn btn-sm btn-info"><i class="fa fa-plus"></i> সম্পদের স্টক (মজুদ) যোগ করুন</button>
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                    <tr>
                                        <th>ক্রমিক</th>
                                        <th>টেন্ডারের ধরণ</th>
                                        <th>টেন্ডার নাম্বার</th>
                                        <th>সম্পদের ধরণ</th>
                                        <th>মোট টাকা</th>
                                        <th>অ্যাকশন</th>
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
   <script>
       $(function () {
           $('#list').DataTable({
               bAutoWidth: false,
               processing: true,
               serverSide: true,
               iDisplayLength: 10,
               ajax: {
                   url: "/admin/get_product_stock",
                   method: "POST",
                   data: function (d) {
                       d._token = $('input[name="_token"]').val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                   {data: 'tender_type', name: 'tender_type'},
                   {data: 'tender_number', name: 'tender_number'},
                   {data: 'asset_type', name: 'asset_type'},
                   {data: 'total_price', name: 'status'},
                   {data: 'action', name: 'action', orderable: false, searchable: false},
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
                           url: "/admin/delete_product_stock",
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
