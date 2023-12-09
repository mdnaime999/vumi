@extends('admin.common.master')
@include('vendor.datatable.datatable_css')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">রোল ম্যানেজমেন্ট</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">হোম</a></li>
                            <li class="breadcrumb-item active">রোল ম্যানেজমেন্ট</li>
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
                                        <i class="fas fa-list"></i> রোল ম্যানেজমেন্ট তথ্য
                                    </h3>
                                </div>
                                <div class="fa-pull-right">
                                    <a class="" href="{{ route('add_role_permission') }}">
                                        <button class="btn btn-info"><i class="fa fa-plus"></i> রোল ম্যানেজমেন্ট যোগ করুন</button>
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                    <tr>
                                        <th>সিঃ</th>
                                        <th>রোল নাম</th>
                                        <th>অনুমতি</th>
                                        <th>অ্যাকশান</th>
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
                   url: "/user/get_role_permissions",
                   method: 'post',
                   data: function (d) {
                       d._token = $('input[name="_token"]').val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                   {data: 'designation', name: 'designation'},
                   {data: 'permission', name: 'permission'},
                   {data: 'action', name: 'action', orderable: false, searchable: false},
               ],
               "aaSorting": []
           });
       });
       function deleterolepermission(id,e) {
           e.preventDefault();
           swal.fire({
               title: "Are you sure?",
               text: "You want to delete this Role Permission??!",
               icon: "warning",
               showCloseButton: true,
               // showDenyButton: true,
               showCancelButton: true,
               confirmButtonText: `Delete`,
               // dangerMode: true,
           }).then((result) => {
               if (result.value == true) {
                   swal.fire({
                       title: 'Deleted!',
                       text: 'Role Permission is deleted Successfully!',
                       icon: 'success'
                   }).then(function () {
                       $.ajax({
                           url: '{{url("user/delete_role_permission")}}',
                           method: 'POST',
                           data: {id: id, "_token": "{{ csrf_token() }}"},
                           dataType: 'json',
                           success: function () {
                               location.reload(true);
                           }
                       })
                   })
               } else if (result.value == false) {
                   swal.fire("Cancelled", "Role Permission is safe :)", "error");
               }
           })
       }
   </script>
@endsection
