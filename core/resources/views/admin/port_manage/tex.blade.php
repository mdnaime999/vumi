@extends('admin.common.master')
@section('content')
    <div class="content-wrapper">
        <section class="content" style="background: white; margin-top: 14px;">
            <div class="container-fluid">
                <div class="text-right printButton">
                    <a href="{{ route('add_tex', ['id' => $id]) }}">
                        <button type="button" class="btn btn-sm btn-info">নতুন যোগ করুণ</button>
                    </a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">প্রিন্ট</button>
                </div>
                <div class="text-center">
                    <h5>বাংলাদেশ স্থলবন্দর কর্তৃপক্ষ</h5>
                    <h6>স্থলবন্দর, এফ -১৯/এ, আগারগাঁও</h6>
                    <h6>শেরেবাংলা নগর , ঢাকা -১২০৭</h6>
                    <h6 style="margin-bottom: 0px; margin-top: 26px;"><u>বাংলাদেশ স্থলবন্দর কর্তৃপক্ষের
                            নিয়ন্ত্রণাধীন বিভিন্ন স্থলবন্দরের জন্য
                            অধিগ্রহণকৃত কর হিসাব বিবরণী:</u></h6>
                </div>
            </div>

            <div class="card-body">
                <div id="ajaxData">
                    <table id="list" class="table table-bordered" style="border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="width: 5%">ক্রমিক</th>
                                <th style="text-align: center">তারিখ</th>
                                <th style="text-align: center">টাকা</th>
                                <th style="text-align: center">ট্যাক্স
                                ডকুমেন্ট</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($texs as $key => $item)
                                <tr>
                                    <td style="text-aligin: center;">{{ en_to_bn($key + 1) }}.</td>
                                    <td style="text-align: center;">{{ en_to_bn($item->date) }}</td>
                                    <td style="text-align: center;">{{ en_to_bn($item->amount) }}</td>
                                    @if($item->document)
                                    <td style="text-align: center;">ডকুমেন্ট <a style="color:red;" class="hoverContent"
                                                    href="{{ asset($item->document) }}" target="__blank">ক্লিক করুন</a>
                                            </td>
                                    @else
                                    <td style="text-align: center;">ডকুমেন্ট নাই
                                            </td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script-resource')
@endsection
