@extends('admin.common.master')
@include('vendor.datatable.datatable_css')
@section('content')
<?php $access = config('global.access') ? config('global.access') : [];
$checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">ব্যবহারকরী</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">হোম</a></li>
                            <li class="breadcrumb-item active">ব্যবহারকরী</li>
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
                                        <i class="fas fa-list"> ব্যবহারকরী তথ্যবলি</i>
                                    </h3>
                                </div>
                                <div class="fa-pull-right @if(array_search("user/entry",$access) > -1 || $checkAdmin) @else d-none @endif">
                                    <a class="" href="{{ route('add_user') }}">
                                        <button class="btn btn-info"><i class="fa fa-plus"></i> ব্যবহারকরী যোগ করুন</button>
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>নাম</th>
                                            <th>ইমেইল</th>
                                            <th>ফোন</th>
                                            <th>বিভাগ/পদবী/অনুমতি</th>
                                            <th>স্ট্যাটাস</th>
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
                   url: "/user/get_users",
                   method: 'post',
                   data: function (d) {
                       d._token = $('input[name="_token"]').val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                   {data: 'name', name: 'name'},
                   {data: 'email', name: 'email'},
                   {data: 'phone', name: 'phone'},
                   {data: 'role', name: 'role'},
                   {data: 'status', name: 'status'},
                   {data: 'action', name: 'action', orderable: false, searchable: false},
               ],
               "aaSorting": []
           });
       });
       function deleteuser(id,e) {
           e.preventDefault();
           swal.fire({
               title: "Are you sure?",
               text: "You want to delete this User??!",
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
                       text: 'User is deleted Successfully!',
                       icon: 'success'
                   }).then(function () {
                       $.ajax({
                           url: "/user/delete_user",
                           method: 'POST',
                           data: {id: id, "_token": "{{ csrf_token() }}"},
                           dataType: 'json',
                           success: function () {
                               location.reload(true);
                           }
                       })
                   })
               } else if (result.value == false) {
                   swal.fire("Cancelled", "User is safe :)", "error");
               }
           })
       }
   </script>
@endsection
