@extends('admin.common.master')
@include('admin.port.port_form_css')
@section('header-resource')
@livewireStyles
@endsection
@section('breadcumb')
    <div class="content-wrapper" style="font-family: Roboto">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h5 class="m-0 text-dark">সংরক্ষিত</h5>
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
                            <h3 class="card-title mb-0">সংরক্ষিত যোগ করুন</h3>
                        </div>
                        @livewire('add-port')
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
@include('admin.port.port_form_js')
@section('script-resource')
@livewireScripts
<script>

</script>
@endsection
