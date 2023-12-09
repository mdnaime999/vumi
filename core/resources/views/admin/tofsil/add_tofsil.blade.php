@extends('admin.common.master')
@include('admin.tofsil.tofsil_form_css')
@section('header-resource')
@livewireStyles
@endsection
@section('breadcumb')
    <div class="content-wrapper" style="font-family: Roboto">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h5 class="m-0 text-dark">তফসিল </h5>
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
                            <h3 class="card-title mb-0">তফসিল  যোগ করুন</h3>
                        </div>

                        {{-- <form method="POST" action="{{route('save.tofsil')}}"  id="frmCheckout" enctype="multipart/form-data" role="form">
                            @csrf
                            @include('admin.tofsil.tofsil_form')

                        </form> --}}
                        @livewire('tofsil')
                    </div>
                </div>
            </div>

        </div>
    </section>
    </div>
@endsection
@include('admin.tofsil.tofsil_form_js')
@section('script-resource')
@livewireScripts
<script>

</script>
@endsection

