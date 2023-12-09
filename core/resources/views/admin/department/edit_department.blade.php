@extends('admin.common.master')

@include('admin.department.department_css')

@section('breadcumb')
<?php
    use Illuminate\Support\Facades\Auth;
    $access = config('global.access') ? config('global.access') : [];
    $checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false
?>
    <div class="content-wrapper" style="font-family: Roboto">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">বিভাগ</h1>
                    </div>
                </div>
            </div>
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
                                <h3 class="card-title mb-0"> আপডেট বিভাগ </h3>
                                <div class="fa-pull-right @if(array_search("admin/manage/department", $access) > -1 || $checkAdmin) @else d-none @endif">
                                    <a class="" href="{{ route('manage.department') }}">
                                        <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> বিভাগে ফিরে যান</button>
                                    </a>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('update.department') }}" enctype="multipart/form-data" role="form">
                                @csrf
                                <input type="hidden" value="{{ encrypt($department->id) }}"
                                    name="id">
                                @include('admin.department.department_form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@include('admin.department.department_js')
