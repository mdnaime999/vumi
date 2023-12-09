@extends('admin.common.master')

@section('content')
    <div class="content-wrapper">
        <section class="content" style="background: white; margin-top: 14px">
            <div class="container-fluid">
                <div class="text-right printButton">
                    <button type="button" class="btn btn-sm btn-primary" onclick="window.print()"><span class="fa fa-print"></span> Print </button>
                </div>
                <div class="text-center">
                    <div class="row">
                        <div class="mb-2">
                            <img src="{{ asset('assets/admin/images/logo.png') }}" alt="" style="width: 60px">
                        </div>
                        <div>
                            <h5 style="font-weight: bold;">বাংলাদেশ স্থল বন্দর কর্তৃপক্ষ</h5>
                            <h6>টি. সি. বি. ভবন (৬ষ্ঠ তলা), কারওয়ান বাজার, ঢাকা - ১২১৫</h6>
                            <h5 style="font-weight: bold;"><u>স্টেশনারী চাহিদা ফরম</u></h5>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-10">চাহিদাকারীর নাম ও পদবী: <span class="text-bold">{{ $requisition->users->name ?? '' }}, {{ $requisition->users->roles->designations->name ?? '' }}</span></div>
                    <?php
                        $date = \Carbon\Carbon::parse($requisition->date)->format('d-m-Y');
                    ?>
                    <div class="col-md-2">তারিখ: <span class="text-bold">{{ en_to_bn($date) }}</span></div>
                </div>
            </div>
            <div class="card-body">
                <table id="list" class="table table-bordered border" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 8%;">ক্রমিক নং</th>
                            <th style="text-align: center; width: 50%">মালামালের বিবরণ</th>
                            <th style="text-align: center; width: 15%;">চাহিদার পরিমান</th>
                            <th style="text-align: center; width: 10%">ইতিপূর্বে সরবরাহের তারিখ</th>
                            <th style="text-align: center">মন্তব্য</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requisition->requisition_details as $key => $item)
                            <tr>
                                <td style="text-align: center">{{ $key+1 }}</td>
                                <td style="text-align: center">{{ $item->product_id ? $item->products->name: '' }}</td>
                                <td style="text-align: center">{{ $item->product_need ? $item->product_need : ''}}</td>
                                <td style="text-align: center">{{ $item->previous_date ? \Carbon\Carbon::parse($item->previous_date)->format('d-m-Y') : '' }}</td>
                                <td style="text-align: center">{{ $item->comment ? $item->comment : '' }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="container-fluid pt-4">
                <div class="">চাহিদাকারীর স্কাক্ষর</div>
            </div>
            <div class="container-fluid pt-5 pb-5">
                <div class="row">
                    <div class="text-left col-md-4">কর্মকর্তার স্কাক্ষর</div>
                    <div class="text-center col-md-4">অনুমোদনকারীর স্কাক্ষর</div>
                    <div class="text-right col-md-4">গ্রহণকারীর স্কাক্ষর</div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script-resource')
@endsection
