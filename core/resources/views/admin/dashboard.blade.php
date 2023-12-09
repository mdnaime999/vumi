@extends('admin.common.master')
@section('content')
    <div class="content-wrapper">
        <section class="content" style="background: white; margin-top: 14px;">
            <div class="container-fluid">
                <div class="text-right printButton">
                    <a href="{{ route('add_port') }}">
                        <button type="button" class="btn btn-sm btn-info">Add</button>
                    </a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">Print</button>
                </div>
                <div class="text-center">
                    <h5>ভূমি রেকর্ড ও জরিপ অধিদপ্তর</h5>
                    <h6>তেজগাও</h6>
                    <h6>ঢাকা - ১২০৭</h6>
                    <h6>প্রেস সামগ্রী</h6>
                    <h6 style="margin-bottom: 0px; margin-top: 26px;"><u>প্রাপ্তী</u></h6>
                </div>
            </div>
            <div class="card-body">
                <table id="list" class="table table-bordered" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="width: 5%">ক্রমিক নং</th>
                            <th style="width: 15%; text-align: center;">তারিখ</th>
                            <th style="text-align: center;">মালামাল প্রাপ্তির আদেশ নং</th>
                            <th style="text-align: center">মালামাল বিবরণ </th>
                            <th style="text-align: center">মালামাল এর পরিমান</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>৩</td>
                            <td>১৩/০৩/২০২০</td>
                            <td>আই ও ই বাংলাদেশ লিমিটেড বাড়ি নং - ৫৪(৫ম ফ্লোর), রোড নং-১৩২ ১২-১২ হইতে স্মারক নং ৩১,০০০,০০০-২১৬,০৭,০০৪,১৭,১১ এর ০৭/০১/২০২০ তারিখের কথারদেসগ মতাবেক বুজিয়া পাওয়া গেল</td>
                            <td>ড্রাম কার্টিজ - ৫৫৫০ * প্রতিটির মূল্য ২৯৫০০ টাকা হারে সব মোট মূল্য ১৭,৭০০০০,০০</td>
                            <td>৬০ টি</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
@section('script-resource')
<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
    $(document).ready(function() {
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    });
</script>
@endsection
