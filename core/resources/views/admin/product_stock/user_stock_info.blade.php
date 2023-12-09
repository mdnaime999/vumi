@extends('admin.common.master')

@include('vendor.datatable.datatable_css')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">ব্যবহারকারীর স্টক (মজুদ) তথ্য</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">হোম</a></li>
                            <li class="breadcrumb-item active">ব্যবহারকারীর স্টক (মজুদ) তথ্য</li>
                        </ol>
                    </div>
                </div>
                <div class="text-center">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" onkeyup="searchUserStock()" id="user_name" placeholder="ব্যবহারকারীর নাম দিয়ে খুঁজুন">
                            <input type="hidden" id="token" value="{{ @csrf_token() }}">
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                </div>
            </div>
            <section class="content search_item">

            </section>
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                    <tr>
                                        <th>ক্রমিক</th>
                                        <th>নাম</th>
                                        <th>স্টক তথ্য</th>
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
    @include('admin.product_stock.product_stock_js')
   <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
   <script>
       $(function () {
           $('#list').DataTable({
               bAutoWidth: false,
               processing: true,
               serverSide: true,
               iDisplayLength: 10,
               ajax: {
                   url: "/admin/get_user_stock_info",
                   method: "POST",
                   data: function (d) {
                       d._token = $('input[name="_token"]').val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                   {data: 'name', name: 'name'},
                   {data: 'stock', name: 'stock'},
               ],
               "aaSorting": []
           });
       });
   </script>
@endsection
