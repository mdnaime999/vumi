@extends('admin.common.master')
@include('vendor.datatable.datatable_css')
@section('content')
<?php

use Illuminate\Support\Facades\Auth;

 $access = config('global.access') ? config('global.access') : [];
$checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">স্থাপনা</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">হোম</a></li>
                            <li class="breadcrumb-item active">স্থাপনা</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
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
                                        <i class="fas fa-list"></i>স্থাপনা তথ্য
                                    </h3>
                                </div>
                                <div class="fa-pull-right @if(array_search("admin/add/establishment", $access) > -1 || $checkAdmin) @else d-none @endif">
                                    <a class="" href="{{ route('add.establishment') }}">
                                        <button class="btn btn-info"><i class="fa fa-plus"></i>স্থাপনা যোগ করুন</button>
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                    <tr>
                                        <th>ক্রমিক</th>
                                        <th>বন্দর নাম</th>
                                        <th>স্থাপনা সংখ্যা </th>
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
                   url: '{{url("admin/get_establishment")}}',
                   method: 'post',
                   data: function (d) {
                       d._token = $('input[name="_token"]').val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                   {data: 'portName', name: 'portName'},
                   {data: 'builidingCount', name: 'builidingCount'},
                   {data: 'action', name: 'action', orderable: false, searchable: false},
               ],
               "aaSorting": []
           });
       });
       function deleteEstablishment(id,e) {
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
                       $.ajax({
                           url: '{{url("admin/delete_establishment")}}',
                           method: 'POST',
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
