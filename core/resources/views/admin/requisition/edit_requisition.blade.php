@extends('admin.common.master')
@include('User::user.user_form_css')
@section('breadcumb')
    <div class="content-wrapper" style="font-family: Roboto">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">User</h1>
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
                                    <h3 class="card-title mb-0">Edit User</h3>
                                </div>

                                <form method="POST" action="{{route('update_user')}}"  id="frmCheckout" enctype="multipart/form-data" role="form">
                                    @csrf
                                    <input type="hidden" value="{{ \App\Libraries\Encryption::encodeId($user->id) }}" name="user_id">
                                    @include('User::user.user_form')
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
    </div>
@endsection
@include('User::user.user_form_js')
