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
                        <h1 class="m-0 text-dark">স্টেশনারী চাহিদা</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">হোম</a></li>
                            <li class="breadcrumb-item active"> স্টেশনারী চাহিদা</li>
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
                                        <i class="fas fa-list"></i> স্টেশনারী চাহিদা তথ্য
                                    </h3>
                                </div>
                                <div class="fa-pull-right @if(array_search("admin/manage/requisition", $access) > -1 || $checkAdmin) @else d-none @endif">
                                    <a class="" href="{{ route('add.requisition') }}">
                                        <button class="btn btn-sm btn-info"><i class="fa fa-plus"></i> স্টেশনারী চাহিদা যোগ করুন</button>
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                    <tr>
                                        <th>ক্রমিক</th>
                                        <th>চাহিদাকারীর নাম</th>
                                        <th>পণ্যের নাম</th>
                                        <th>তারিখ</th>
                                        <th>স্ট্যাটাস</th>
                                        <th>প্রেরণ</th>
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
        <div class="modal fade" id="dispatchModal" tabindex="-1" role="dialog" aria-labelledby="dispatchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dispatchModalLabel">স্টেশনারী চাহিদা প্রেরণ করুন</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('send.dispatch') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>সিলেক্ট ব্যবহারকারী</label>
                                    <select name="user_id" class="form-control select2" required autofocus>
                                        <option value="" disabled selected>সিলেক্ট ব্যবহারকারী</option>
                                        @foreach ($users as $user)
                                            @if ($user->type != "superadmin" && $user->id != Auth::guard('web')->user()->id)
                                                <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->designation_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="requisition_id" id="requisition_id" value="">
                            <input type="hidden" name="user_id" id="user_id" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">বাতিল করুন</button>
                            <button type="submit" class="btn btn-outline-primary" data-dismiss="modal">প্রেরণ করুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script-resource')
   @include('vendor.datatable.datatable_js')
   @include('vendor.sweetalert2.sweetalert2_js')
   <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
   <script>
    function dispatchModal(id, value) {
        $("#dispatchModal").modal('show');
        $("#requisition_id").val(id);
        $("#user_id").val(value);
    }
       $(function () {
           $('#list').DataTable({
               bAutoWidth: false,
               processing: true,
               serverSide: true,
               iDisplayLength: 10,
               ajax: {
                   url: "/admin/get_requisition_request",
                   method: 'post',
                   data: function (d) {
                       d._token = $('input[name="_token"]').val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                   {data: 'user_name', name: 'user_name'},
                   {data: 'product_name', name: 'product_name'},
                   {data: 'date', name: 'date'},
                   {data: 'status', name: 'status'},
                   {data: 'dispatch', name: 'dispatch'},
                   {data: 'action', name: 'action', orderable: false, searchable: false},
               ],
               "aaSorting": []
           });
       });
       function deleteRequisition(id,e) {
           e.preventDefault();
           swal.fire({
               title: "আপনী কি নিশ্চিত?",
               text: "আপনি মুছে দিতে চান??!",
               icon: "warning",
               showCloseButton: true,
               // showDenyButton: true,
               showCancelButton: true,
               confirmButtonText: `Delete`,
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
                           url: "/admin/delete_requisition",
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
