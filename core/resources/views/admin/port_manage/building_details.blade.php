@extends('admin.common.master')

@section('content')
    <div class="content-wrapper">
        <section class="content" style="background: white; margin-top: 14px;">
            <div class="container-fluid">
                <div class="text-right printButton">
                    <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">Print</button>
                </div>
                <div class="text-center">
                    <h5>{{ $port_name->port_name }}</h5>
                    <h6>স্থাপনা বিস্তারিত</h6>
                    <h6 style="margin-bottom: 0px; margin-top: 26px;"><u>বাংলাদেশ স্থলবন্দর কর্তৃপক্ষের
                        নিয়ন্ত্রণাধীন বিভিন্ন স্থলবন্দরের জন্য
                        অধিগ্রহণকৃত বিল্ডিং বিবরণী:</u></h6>
                </div>
            </div>

            <div class="card-body">
                {{-- <div class="row text-center">
                    <div class="col-md-6">
                        বিল্ডিং নাম:- <br> {{ $building->name }}
                    </div>
                    <div class="col-md-6">
                        বিল্ডিং বিস্তারিত:- <br> {{ $building->details }}
                    </div>
                </div> --}}

                <table id="list" class="table table-bordered" style="border-collapse: collapse;">

                    <thead>
                        <tr>
                            <th style="text-align: center">ক্রমিক</th>
                            <th style="text-align: center">নাম</th>
                            <th style="text-align: center">সংখ্যা</th>
                            <th style="text-align: center">আয়তন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buildings as $key => $item)
                            <tr>
                                <td style="text-align: center">{{ en_to_bn($key + 1) }}.</td>

                                <td style="text-align: center"><a href="{{ route('infrasture.details', ['id' => $item->id]) }}">{{ $item->name }}</a></td>
                                @foreach ($item->buildingDetials as $key => $detail)
                                    @if($key < 2)
                                        <td style="text-align: center">{{ en_to_bn($detail->number) }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </section>
    </div>
@endsection
@section('script-resource')

@endsection
