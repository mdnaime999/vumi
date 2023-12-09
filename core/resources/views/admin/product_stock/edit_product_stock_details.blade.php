@extends('admin.common.master')

@include('admin.product_stock.product_stock_css')

@section('breadcumb')
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
                                    <div class="fa-pull-right">
                                        <a class="" href="{{ route('manage.product.stock.details',['id'=>$product_stock->product_stock_id]) }}">
                                            <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> ফিরে যান সম্পদের স্টক (মজুদ)</button>
                                        </a>
                                    </div>
                                </div>

                                <form method="POST" action="{{route('update.product.stock.details')}}"  id="frmCheckout" enctype="multipart/form-data" role="form">
                                    @csrf
                                    <input type="hidden" value="{{ $product_stock->id }}" name="id">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label> নাম <span class="text-gray">*</span></label>
                                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $product_stock->name }}" placeholder="পেন্সিল" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label> স্টক (মজুদ) <span class="text-gray">*</span></label>
                                                    <input type="text" class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" name="stock" value="{{ $product_stock->stock }}" placeholder="১০০" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label> সম্পদের ধরণ </label>
                                                    <select class="form-control" name="type" autofocus>
                                                        <option value="5" @if ($product_stock->type == '5') selected @endif>সংখ্যা</option>
                                                        <option value="1" @if ($product_stock->type == '1') selected @endif>প্যাঃ</option>
                                                        <option value="2" @if ($product_stock->type == '2') selected @endif>বক্স</option>
                                                        <option value="3" @if ($product_stock->type == '3') selected @endif>রোল</option>
                                                        <option value="4" @if ($product_stock->type == '4') selected @endif>বোতল</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label> মূল্য </label>
                                                    <input type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ $product_stock->price }}" placeholder="১০০০" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label> কেনার তারিখ </label>
                                                    <input type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{ $product_stock->date }}" autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('manage.product.stock.details',['id'=>$product_stock->product_stock_id]) }}">
                                                <button type="button" class="btn btn-danger">বাতিল </button>
                                            </a>
                                            <button onclick="typeSubmit()" type="submit" class="btn btn-info float-right">আপডেট করুন</button>
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

@include('admin.product_stock.product_stock_js')
