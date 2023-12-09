@extends('admin.common.master')
@include('vendor.datatable.datatable_css')
@section('content')
    <style>
        .accordion-wrapper-t .form-check-input:focus {
            box-shadow: none;

        }

        .accordion-wrapper-t .accordion-button:not(.collapsed) {
            color: #0c63e4;
            background-color: transparent;
            box-shadow: none;
        }

        .accordion-wrapper-t {
            position: relative;
        }

        .accordion-wrapper-t .accordion-body {
            padding: 0.5rem .75rem;
            margin-left: 15px;
        }

        .accordion-wrapper-t .accordion-button {
            padding: .5rem .75rem;
            margin-left: 20px;

        }

        .accordion-wrapper-t:before {
            top: 0;
            bottom: 0;
            position: absolute;
            content: " ";
            border-left: 1px dotted #000;
            left: 30px;
            height: 100%;
        }

        .accordion-wrapper-t .accordion-button::after {

            background-image: none;

        }

        .accordion-wrapper-t .accordion-button:focus {
            z-index: 3;
            border-color: none;
            outline: 0;
            box-shadow: none;
        }

        .accordion-wrapper-t .accordion-item {
            background-color: #fff;
            border: none;
        }

        .accordion-wrapper-t .accordion-button:not(.collapsed),
        .accordion-wrapper-t .accordion-button {
            border-bottom: none;
        }

        .accordion-wrapper-t .accordion-button:not(.collapsed)::after {
            background-image: none;
            content: "-";
            transform: none;
            transform: rotate(0deg);
        }

        .accordion-wrapper-t .accordion-button:after {
            content: "+";
            transform: none;
        }

        .accordion-wrapper-t .accordion-button::after {
            text-align: center;
            position: absolute;
            background-image: none;
            left: -30px;
            border: 1px solid #000;
            background-color: #fff;
        }

        .accordion-wrapper-t .accordion-button:before {
            top: 50%;
            left: -10px;
            position: absolute;
            content: " ";
            width: 12px;
            border-top: 1px dotted #000;
        }

        .accordion-wrapper-t .accordion-item {
            padding-left: 30px;
        }

        .accordion-wrapper-t ul.timeline-ww {
            list-style-type: none;
            position: relative;
            margin-left: 12px;
            padding: 0px;
        }

        .accordion-wrapper-t ul.timeline-ww:before {
            content: ' ';
            border-left: 1px dotted #000;
            display: inline-block;
            position: absolute;
            left: 0px;
            /* width: 2px; */
            height: 100%;
            z-index: 400;
            top: -10px;
        }

        .accordion-wrapper-t ul.timeline-ww>li {
            padding-left: 30px;
            margin: 10px 0px;
            position: relative;
        }

        .accordion-wrapper-t ul.timeline-ww>li::before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-top: 1px dotted #000;
            left: 1px;
            width: 20px;
            height: 2px;
            z-index: 400;
            margin: 13px 0px;
        }
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">রোল ম্যানেজমেন্ট</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">হোম</a></li>
                            <li class="breadcrumb-item active">রোল ম্যানেজমেন্ট</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container pt-5">
                <div class="accordion-wrapper-t accordion accordion-flush position-relative">
                    @foreach ($departments as $department)
                        <div class="accordion-item" id="accordionFlushExample{{ $department->id }}">
                            <h2 class="accordion-header" id="flush-heading{{ $department->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $department->id }}" aria-expanded="true" aria-controls="flush-collapse{{ $department->id }}">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault{{ $department->id }}">
                                        <label class="form-check-label" for="flexCheckDefault{{ $department->id }}">
                                            {{ $department->name }} ({{ en_to_bn($department->designations->count()) }})
                                        </label>
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-collapse{{ $department->id }}" class="accordion-collapse collapse"
                                aria-labelledby="flush-heading{{ $department->id }}" data-bs-parent="#accordionFlushExample{{ $department->id }}">
                                <div class="accordion-body">
                                    <ul class="timeline-ww">
                                        @foreach ($department->designations as $designation)
                                            <li>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheck{{ $designation->id }}">
                                                    <label class="form-check-label" for="flexCheck{{ $designation->id }}">
                                                        {{ $designation->name }}
                                                    </label>
                                                </div>
                                            </li>
                                            {{-- Static --}}
                                            @if(strpos($designation->name, "চেয়ারম্যান") !== false)
                                                <div class="accordion-body">
                                                    <ul class="timeline-ww">
                                                        <li>
                                                            <div class="form-check mb-0">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckStatic">
                                                                <label class="form-check-label" for="flexCheckStatic">চেয়ারম্যান </label>
                                                            </div>
                                                        </li>
                                                        <div class="accordion-body">
                                                            <ul class="timeline-ww">
                                                                <li>
                                                                    <div class="form-check mb-0">
                                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckStatic2">
                                                                        <label class="form-check-label" for="flexCheckStatic2">জনাব মোঃ আলমগীর</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <li>
                                                            <div class="form-check mb-0">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckStatic">
                                                                <label class="form-check-label" for="flexCheckStatic">একান্ত সচিব</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check mb-0">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckStatic">
                                                                <label class="form-check-label" for="flexCheckStatic">কম্পিউটার অপারেটর </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check mb-0">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckStatic">
                                                                <label class="form-check-label" for="flexCheckStatic">কার ড্রাইভার</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check mb-0">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckStatic">
                                                                <label class="form-check-label" for="flexCheckStatic">এম, এল, এস, এস</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                            {{-- Static --}}
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script-resource')
@endsection
