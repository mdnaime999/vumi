<div class="card-body">
    <div class="row">
        <!-- <div class="col-md-4">
            <div class="form-group">
                <label for="port">বন্দর<span class="text-danger">*</span></label>
                <select id="port" class="form-control" name="port" value="">
                    <option selected disabled>বন্দর নির্বাচন করুন</option>
                    @foreach ($ports as $port)
                        <option value="{{ $port->id }}">
                            {{ __($port->port_name) }}</option>
                    @endforeach
                </select>
            </div>
        </div> -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="l_s_case_id">এল এ কেস নং <span class="text-danger">*</span></label>
                <select id="l_s_case_id" class="form-control" name="l_s_case_id">
                    <option selected disabled>এল এ কেস নং  নির্বাচন করুন</option>
                    @foreach ($lsCases as $lsCase)
                        <option value="{{ $lsCase->id }}">
                            {{ __($lsCase->number) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="kotian_no">খতিয়ান নং <span class='required-star'>*</span></label>
                <input id="kotian_no" type="text" class="form-control{{ $errors->has('kotian_no') ? ' is-invalid' : '' }}" name="kotian_no" value="{{ old('kotian_no', optional($tofsil)->kotian_no) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="dag_no">দাগ নং(এস. এ) <span class='required-star'>*</span></label>
                <input id="dag_no" type="text" class="form-control{{ $errors->has('dag_no') ? ' is-invalid' : '' }}" name="dag_no" value="{{ old('dag_no', optional($tofsil)->dag_no) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="classified_type_id">জমি শ্রেণী (এস. এ)<span class="text-danger">*</span></label>
                <select id="classified_type_id" class="form-control select2bs4" name="classified_type_id" value="">
                    <option selected disabled>জমির শ্রেণী নির্বাচন করুন</option>
                    @foreach ($classifications as $classification)
                        <option value="{{ $classification->id }}" @if (optional($tofsil)->classified_type_id == $classification->id) selected @endif>
                            {{ __($classification->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="land_type_id">জমির ধরণ<span class="text-danger">*</span></label>
                <select id="land_type_id" class="form-control select2bs4" name="land_type_id" value="">
                    <option selected disabled>জমি শ্রেণী নির্বাচন করুন</option>
                    @foreach ($landTypes as $landType)
                        <option value="{{ $landType->id }}" @if (optional($tofsil)->land_type_id == $landType->id) selected @endif>
                            {{ __($landType->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="total_land">জমির পরিমাণ(একরে)<span class='required-star'>*</span></label>
                <input id="total_land" type="text" class="form-control{{ $errors->has('total_land') ? ' is-invalid' : '' }}" name="total_land" value="{{ old('total_land', optional($tofsil)->total_land) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="comment">মন্তব্য<span class='required-star'>*</span></label>
                <input id="comment" type="text" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" value="{{ old('comment', optional($tofsil)->comment) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            {{-- {{status}}--}}
            <div class="form-group">
                <label for="status"> স্ট্যাটাস <span class='required-star'>*</span></label>
                <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" autofocus>
                    <option value="" selected disabled>স্ট্যাটাস নির্বাচন করুন</option>
                    <option value="1" @if (optional($tofsil)->status == "1")
                        selected
                        @endif selected>সক্রিয়</option>
                    <option value="0" @if (optional($tofsil)->status == "0")
                        selected
                        @endif>নিষ্ক্রিয়</option>
                </select>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('manage.tofsil') }}">
            <button type="button" class="btn btn-danger">বাতিল </button>
        </a>
        <button onclick="typeSubmit()" type="submit" class="btn btn-info float-right">সেভ করুন</button>
    </div>
