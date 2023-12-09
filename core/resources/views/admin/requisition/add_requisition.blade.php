@extends('admin.common.master')
@include('admin.requisition.requisition_css')
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
                    <h5 class="m-0 text-dark">স্টেশনারী চাহিদা</h5>
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
                            <h3 class="card-title mb-0">স্টেশনারী চাহিদা যোগ করুন</h3>
                            <div class="fa-pull-right @if(array_search("admin/manage/requisition", $access) > -1 || $checkAdmin) @else d-none @endif">
                                <a class="" href="{{ route('manage.requisition') }}">
                                    <button class="btn btn-sm btn-primary"><i class="fa fa-reply"></i> ফিরে যান স্টেশনারী চাহিদাতে</button>
                                </a>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('save.requisition') }}" id="frmCheckout" enctype="multipart/form-data" role="form">
                            @csrf
                            @include('admin.requisition.requisition_form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection

@include('admin.requisition.requisition_js')
