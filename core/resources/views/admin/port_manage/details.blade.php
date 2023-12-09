@extends('admin.common.master')
@section('content')
    <div class="content-wrapper">
        <section class="content" style="background: white; margin-top: 14px;">
            <div class="container-fluid">
                <div class="text-right printButton">
                    <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">প্রিন্ট</button>
                </div>
                <div class="text-center">
                    <h5>{{ $building->name }} বিস্তারিত</h5>
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
                            <th style="text-align: center">নির্মাণ সাল </th>
                            <th style="text-align: center">নির্মাণ ব্যয়</th>
                            <th style="text-align: center">ধারণ ক্ষমতা </th>
                            <th style="text-align: center">ব্যবহৃত</th>
                            <th style="text-align: center">অবচয়(মূল্য হ্রাস)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $value = 0; ?>
                        <tr>
                            <td style="text-align: center;">১.</td>
                            <td style="text-align: center;">{{ $building->name }}</td>
                                @foreach ($infrastures as $key => $item)
                                    @if($key > 1)
                                        <td style="text-align: center">{{ en_to_bn($item->number) }}</td>
                                    @endif
                                    @if($key == 3)
                                        <?php $value = $item->number; ?>
                                    @endif
                                @endforeach
                            <td style="text-align: center;">অবচয়(মূল্য হ্রাস) হিসাব <a href="{{ route('depreciation.calclution', ['number' => $value]) }}">ক্লিক করুন</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
@section('script-resource')

@endsection
