@extends('admin.common.master')
@include('User::user.user_form_css')
@section('breadcumb')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">Role Permission</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        @endsection

        @section('content')
            <section class="content">
                <div class="container-fluid">

                    @include('message.message')

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title mb-0">Edit Role Permission</h3>
                                </div>

                                <form method="POST" action="{{route('update_role_permission')}}"  id="frmCheckout" enctype="multipart/form-data" role="form">
                                    @csrf
                                    <input type="hidden" value="{{ \App\Libraries\Encryption::encodeId($permission->id) }}" name="permission_id">
                                    @include('User::rolepermission.role_permission_form')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </div>
@endsection
@include('User::rolepermission.role_permission_form_js')
