@extends('admin.common.master')

@include('admin.product_stock.product_stock_css')

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
                        <h1 class="m-0 text-dark">সম্পদের স্টক (মজুদ)</h1>
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
                                    <h3 class="card-title mb-0">আপডেট সম্পদের স্টক (মজুদ)</h3>
                                    <div class="fa-pull-right @if(array_search("admin/manage/product/stock", $access) > -1 || $checkAdmin) @else d-none @endif">
                                        <a class="" href="{{ route('manage.product.stock') }}">
                                            <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> ফিরে যান সম্পদের স্টক (মজুদ)</button>
                                        </a>
                                    </div>
                                </div>

                                <form method="POST" action="{{route('update.product.stock')}}"  id="frmCheckout" enctype="multipart/form-data" role="form">
                                    @csrf
                                    <input type="hidden" value="{{ \App\Libraries\Encryption::encodeId($product_stock->id) }}" name="id">
                                    @include('admin.product_stock.product_stock_form')
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
    </div>
@endsection

@include('admin.product_stock.product_stock_js')
