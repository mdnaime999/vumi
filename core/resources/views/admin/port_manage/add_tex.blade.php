@extends('admin.common.master')

@include('admin.designation.designation_css')

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
                        <h5 class="m-0 text-dark">কর</h5>
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
                                <h3 class="card-title mb-0">কর যোগ করুন</h3>
                                <div class="fa-pull-right @if(array_search("admin/manage/designation", $access) > -1 || $checkAdmin) @else d-none @endif">
                                    <a class="" href="{{ route('manage.designation') }}">
                                        <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> কর ফিরে যান</button>
                                    </a>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('save.tex') }}" enctype="multipart/form-data" role="form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>তারিখ <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="" autofocus>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>টাকা <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="" autofocus>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="total_land">ট্যাক্স ফাইল</label>
                                                <input type="file" class="form-control" style="margin-top: 5px" placeholder="Phone Number" name='tex_file'/>
                                                
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" id="" value="{{ $id }}">
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('ls_case_tax', ['id' => $id]) }}">
                                            <button type="button" class="btn btn-danger">বাতিল </button>
                                        </a>
                                        <button type="submit" class="btn btn-info float-right">সেভ করুন</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
