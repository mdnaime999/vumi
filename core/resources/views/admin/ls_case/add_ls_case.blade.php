@extends('admin.common.master')
@include('admin.ls_case.ls_case_form_css')
@section('breadcumb')
    <div class="content-wrapper" style="font-family: Roboto">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h5 class="m-0 text-dark">এল এ কেস নং </h5>
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
                            <h3 class="card-title mb-0">এল এ কেস নং  যোগ করুন</h3>
                        </div>

                        <form method="POST" action="{{route('save.ls.case')}}"  id="frmCheckout" enctype="multipart/form-data" role="form">
                            @csrf
                            @include('admin.ls_case.ls_case_form')
                        </form>
                        {{-- @livewire('tofsil') --}}
                    </div>
                </div>
            </div>

        </div>
    </section>
    </div>
@endsection
@include('admin.ls_case.ls_case_form_js')
