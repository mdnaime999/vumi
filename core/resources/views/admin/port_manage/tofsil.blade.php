@extends('admin.common.master')
@section('content')
    <div class="content-wrapper">
        <section class="content" style="background: white; margin-top: 14px;">
            <div class="container-fluid">
                <div class="text-center">
                    <div class="text-right printButton">
                        <a href="{{ route('add.tofsil', ['id' => $ls_case->id]) }}">
                            <button type="button" class="btn btn-sm btn-info">Add</button>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">প্রিন্ট</button>
                    </div>
                    <h5>{{ $ls_case->port->port_name }}</h5>
                    <h6>উপজেলা: {{ $ls_case->port->upzilla ?  $ls_case->port->upzilla : ''}}, জেলা: {{ $ls_case->port->district ? $ls_case->port->district : '' }} </h6>
                </div>
                <div class="row">
                    <div class="col-md-6"  style="text-align: -webkit-left;">
                        <table>
                            <tr>
                                <td style="width: 55%;">প্রকল্পের নাম</td>
                                <td style="width: 10%;">:</td>
                                <td>{{ $ls_case->project_name ? $ls_case->project_name : '' }} </td>
                            </tr>
                            <tr>
                                <td style="width: 55%;">এল. এ কেস নং</td>
                                <td style="width: 10%;">:</td>
                                <td>{{ $ls_case->number ? en_to_bn($ls_case->number) : '' }}</td>
                            </tr>
                            <tr>
                                <td style="width: 55%;">দখল হস্তান্তর তারিখ</td>
                                <td style="width: 10%;">:</td>
                                <td>{{ $ls_case->possession_date ? en_to_bn(\Carbon\Carbon::parse($ls_case->possession_date)->format('d/m/Y')) : '' }}</td>
                            </tr>
                            <tr>
                                <td style="width: 55%;">গেজেট প্রকাশের তারিখ </td>
                                <td style="width: 10%;">:</td>
                                <td>{{ $ls_case->gazette_date ? en_to_bn(\Carbon\Carbon::parse($ls_case->gazette_date)->format('d/m/Y')) : '' }}</td>
                            </tr>
                            <tr>
                                <td style="width: 55%;">জোত নং</td>
                                <td style="width: 10%;">:</td>
                                <td>{{ $ls_case->jote_no ? en_to_bn($ls_case->jote_no) : '' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6"  style="text-align: -webkit-right;">
                        <table>
                            <tr>
                                <td style="width: 55%;">জমি অধিগ্রহনের খাত</td>
                                <td style="width: 10%;">:</td>
                                <td>রাজস্ব</td>
                            </tr>
                            <tr>
                                <td style="width: 55%;">জমির পরিমান</td>
                                <td style="width: 10%;">:</td>
                                <td>{{ $ls_case->total_land ? en_to_bn($ls_case->total_land) : '' }}</td>
                            </tr>
                            <tr>
                                <td style="width: 55%;">জমির মূল্য</td>
                                <td style="width: 10%;">:</td>
                                <td style="width: 55%;">{{ $ls_case->land_price ? en_to_bn($ls_case->land_price) : '' }}</td>
                            </tr>
                            <tr>
                                <td style="width: 55%;">নামজারি কেস নং</td>
                                <td style="width: 10%;">:</td>
                                <td>{{ $ls_case->namjari_case_id ? en_to_bn($ls_case->namjari_case_id) : '' }}</td>
                            </tr>
                            <tr>
                                <td style="width: 55%;">নামজারি খতিয়ান নং</td>
                                <td style="width: 10%;">:</td>
                                <td>{{ $ls_case->kotian_no ? en_to_bn($ls_case->kotian_no) : '' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12"
                        style="text-align: center; font-size: 16px; font-weight: bold;line-height: 50px;">
                        <u>তফসিল</u>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4" style="text-align: left;">
                        জেলা:{{ $ls_case->port->district ? $ls_case->port->district : ''}}
                    </div>
                    <div class="col-md-4" style="text-align: center">
                        থানা/উপজেলা: {{ $ls_case->port->upzilla ? $ls_case->port->upzilla : ''}}
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        মৌজা: {{ $ls_case->moja ? $ls_case->moja : ''}}
                    </div>
                </div>
            </div>

            <div class="card-body">


                <table id="list" class="table table-bordered" style="border-collapse: collapse;">

                    <thead>
                        <tr>
                            <th style="text-align: center">ক্রমিক</th>
                            <th style="text-align: center">খতিয়ান নং (এস. এ )</th>
                            <th style="text-align: center">দাগ নং (এস. এ)</th>
                            <th style="text-align: center">জমির শ্রেণী (এস. এ)</th>
                            <th style="text-align: center">আংশিক/পূর্ণ </th>
                            <th style="text-align: center">জমির পরিমান (একরে )</th>
                            <th style="text-align: center">জমি কর খাত</th>
                            <th style="text-align: center">মন্তব্য </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalLand = 0;?>
                        @foreach ($ls_case->tofsil_data as $key => $tofsil_item)
                            <tr>
                                <td style="text-align: center">{{ en_to_bn($key+1) }}.</td>
                                <td style="text-align: center">{{ $tofsil_item->kotian_no ? en_to_bn($tofsil_item->kotian_no) : ''}}</td>
                                <td style="text-align: center">{{ $tofsil_item->dag_no ? en_to_bn($tofsil_item->dag_no) : '' }}</td>
                                <td style="text-align: center">{{ $tofsil_item->classified_type->name ? en_to_bn($tofsil_item->classified_type->name) : '' }}</td>
                                <td style="text-align: center">{{ $tofsil_item->land_type->name ?  en_to_bn($tofsil_item->land_type->name) : ''}}</td>
                                <td style="text-align: center">{{ $tofsil_item->total_land ? en_to_bn($tofsil_item->total_land) : '' }}</td>

                                <td style="text-align: center">{{ $tofsil_item->comment ? en_to_bn($tofsil_item->comment) : ''}}</td>
                                <?php $totalLand += $tofsil_item->total_land ?>
                            </tr>
                        @endforeach
                        <tr>

                            <td colspan="6" style="text-align: right;">মোট জমির পরিমানঃ {{ en_to_bn($totalLand) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
@section('script-resource')
@endsection
