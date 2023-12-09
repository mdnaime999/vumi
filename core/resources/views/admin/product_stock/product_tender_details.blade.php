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
                    <h5><span class="text-bold">{{ $product->name }}</span> স্টক (মজুদ) তথ্য</h5>
                    <h6>মোট স্টক ছিলঃ <span class="text-bold">{{ $product->stock + $product_use->sum('product_need') }}</span></h6>
                    <h6>বর্তমান স্টকঃ <span class="text-bold">{{ $product->stock }}</span></h6>
                    <h6>মোট ব্যবহারঃ <span class="text-bold">{{ $product_use->sum('product_need') }}</span></h6>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="fa-pull-left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list"></i> সম্পদের স্টক (মজুদ) তথ্য
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                    <tr>
                                        <th>ক্রমিক</th>
                                        <th>বন্দরের নাম</th>
                                        <th>টেন্ডারের ধরণ</th>
                                        <th>টেন্ডার নং</th>
                                        <th>পণ্য সংখ্যা</th>
                                        <th>পণ্যের মূল্য</th>
                                        <th>ক্রয়ের তারিখ</th>
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
    <input type="hidden" name="product_id" value="{{ $id }}">
    <script>
        $(function () {
            $('#list').DataTable({
                bAutoWidth: false,
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                ajax: {
                    url: "/admin/get_product_tender_details",
                    method: "POST",
                    data: function (d) {
                        d._token = $('input[name="_token"]').val();
                        d.product_id = $('input[name="product_id"]').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'port_name', name: 'port_name'},
                    {data: 'tender_type', name: 'tender_type'},
                    {data: 'tender_number', name: 'tender_number'},
                    {data: 'stock', name: 'stock'},
                    {data: 'price', name: 'price'},
                    {data: 'date', name: 'date'},
                ],
                "aaSorting": []
            });
        });
    </script>
@endsection
