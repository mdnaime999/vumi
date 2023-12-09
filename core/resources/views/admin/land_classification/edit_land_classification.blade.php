@extends('admin.common.master')
@include('admin.land_classification.land_classification_form_css')
@section('breadcumb')
    <div class="content-wrapper" style="font-family: Roboto">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">জমির শ্রেণীবিভাগ</h1>
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
                                    <h3 class="card-title mb-0">এডিট জমির শ্রেণীবিভাগ</h3>
                                </div>

                                <form method="POST" action="{{route('update.land.classification')}}"  id="frmCheckout" enctype="multipart/form-data" role="form">
                                    @csrf
                                    <input type="hidden" value="{{ \App\Libraries\Encryption::encodeId($classification->id) }}" name="classification_id">
                                    @include('admin.land_classification.land_classification_form')
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
    </div>
@endsection
@include('admin.land_classification.land_classification_form_js')
