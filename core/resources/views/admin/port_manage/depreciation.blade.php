@extends('admin.common.master')
@section('content')
    <div class="content-wrapper">
        <section class="content" style="background: white; margin-top: 14px;">
            <div class="container-fluid">
                <div class="text-right printButton">
                    <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">প্রিন্ট</button>
                </div>
                <div class="text-center">
                    <h5>অবচয়(মূল্য হ্রাস) বিস্তারিত</h5>
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
                            <th style="text-align: center">বছর</th>
                            <th style="text-align: center">শুরু এর টাকা</th>
                            <th style="text-align: center">প্রতি বছর অবচয়(মূল্য হ্রাস)</th>
                            <th style="text-align: center">সঞ্চিত অবচয় (মূল্য হ্রাস)</th>
                            <th style="text-align: center">শেষ টাকা</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Declaration of variables
                        $price = $number;
                        $residual = 200;
                        $accumulateddep = 0;
                        $annualdep = ($price - $residual) / 10;
                        $accumulateddep = $annualdep;
                        $endvalue = $price - $annualdep;
                        //Calculations, Loops and Printing
                        for ($year = 1; $year <= 10; $year++) { ?>
                            <tr>
                            <td style='text-align: center'>{{ en_to_bn($year)}}</td>
                            <td style='text-align: center'>{{en_to_bn($price)}}</td>
                            <td style='text-align: center'>{{en_to_bn($annualdep)}}</td>
                            <td style='text-align: center'>{{en_to_bn($accumulateddep)}}</td>
                            <td style='text-align: center'>{{en_to_bn($endvalue)}}</td>
                            </tr>
                        <?php

                            $price = $endvalue;
                                $accumulateddep += $annualdep;
                                $endvalue = $price - $annualdep;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
@section('script-resource')
@endsection
