@extends('admin.common.master')

@include('vendor.datatable.datatable_css')

@section('content')
    <div class="content-wrapper" style="font-family: Roboto">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h5 class="m-0 text-dark">পদবী</h5>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @include('message.message')
                <div class="row">
                    <div class="col-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title mb-0">পদবী পরিবর্তন করুন</h3>
                                <div class="fa-pull-right">
                                    <a class="" href="{{ route('add.role.transfer') }}">
                                        <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> পদবী ট্রান্সফার করুন</button>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                    <tr>
                                        <th>ক্রমিক</th>
                                        <th>নাম</th>
                                        <th>পদবীর মেয়াদ</th>
                                        <th>পূর্বের বিভাগ/পদবী</th>
                                        <th>বর্তমান বিভাগ/পদবী</th>
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
                   url: "/admin/get_transfer_role",
                   method: "POST",
                   data: function (d) {
                       d._token = $('input[name="_token"]').val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                   {data: 'name', name: 'name'},
                   {data: 'date', name: 'date'},
                   {data: 'previous', name: 'previous'},
                   {data: 'present', name: 'present'},
               ],

               "aaSorting": []
           });
       });
   </script>
@endsection
