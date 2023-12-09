<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="port_id">বন্দর নাম <span class="text-danger">*</span></label>
                <select id="port_id" class="form-control select2bs4" name="port_id" value="">
                    <option selected disabled>বন্দর নির্বাচন করুন</option>
                    @foreach ($ports as $port)
                        <option value="{{ $port->id }}" @if (optional($lsCase)->port_id == $port->id) selected @endif>
                            {{ __($port->port_name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="project_name">প্রকল্পের নাম <span class='required-star'>*</span></label>
                <input id="project_name" type="text" class="form-control{{ $errors->has('project_name') ? ' is-invalid' : '' }}" name="project_name" value="{{ old('project_name', optional($lsCase)->project_name) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="land_owner">জমি অধিগ্রহনের খাত <span class='required-star'>*</span></label>
                <input id="land_owner" type="text" class="form-control{{ $errors->has('land_owner') ? ' is-invalid' : '' }}" name="land_owner" value="{{ old('land_owner', optional($lsCase)->land_owner) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">এল.এ কেস নম্বর <span class='required-star'>*</span></label>
                <input id="number" type="text" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" value="{{ old('number', optional($lsCase)->number) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="total_land">মোট জমির পরিমাণ<span class='required-star'>*</span></label>
                <input id="total_land" type="text" step="0.0001" class="form-control{{ $errors->has('total_land') ? ' is-invalid' : '' }}" name="total_land" value="{{ old('total_land', optional($lsCase)->total_land) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="possession_date">দখল হস্তান্তর তারিখ <span class='required-star'>*</span></label>
                <input id="possession_date" type="date" class="form-control{{ $errors->has('possession_date') ? ' is-invalid' : '' }}" name="possession_date" value="{{ old('possession_date', optional($lsCase)->possession_date) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="land_price">জমির মূল্য</label>
                <input id="land_price" type="text" step="0.0000001" class="form-control{{ $errors->has('land_price') ? ' is-invalid' : '' }}" name="land_price" value="{{ old('land_price', optional($lsCase)->land_price) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="gazette_date">গেজেট প্রকাশের  তারিখ<span class='required-star'>*</span></label>
                <input id="gazette_date" type="date" class="form-control{{ $errors->has('gazette_date') ? ' is-invalid' : '' }}" name="gazette_date" value="{{ old('gazette_date', optional($lsCase)->gazette_date) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="namjari_case_id">নামজারী কেস নং<span class='required-star'>*</span></label>
                <input id="namjari_case_id" type="text" class="form-control{{ $errors->has('namjari_case_id') ? ' is-invalid' : '' }}" name="namjari_case_id" value="{{ old('namjari_case_id', optional($lsCase)->namjari_case_id) }}" autofocus>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="jote_no">জোত নং </label>
                <input id="jote_no" type="text" class="form-control{{ $errors->has('jote_no') ? ' is-invalid' : '' }}" name="jote_no" value="{{ old('jote_no', optional($lsCase)->jote_no) }}" autofocus>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="kotian_no">নামজারি খতিয়ান নং</label>
                <input id="kotian_no" type="text" class="form-control{{ $errors->has('kotian_no') ? ' is-invalid' : '' }}" name="kotian_no" value="{{ old('kotian_no', optional($lsCase)->kotian_no) }}" autofocus>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="district">জেলা <span class="text-danger">*</span></label>
                <input id="district" type="text" class="form-control{{ $errors->has('district') ? ' is-invalid' : '' }}" name="district" value="{{ old('district', optional($lsCase)->district) }}" autofocus>
                {{-- <select id="district" class="form-control select2" name="district" value="">
                    <option selected disabled>জেলা নির্বাচন করুন</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->bn_name }}" @if (optional($lsCase)->district == $district->bn_name) selected @endif>
                            {{ __($district->bn_name) }}</option>
                    @endforeach
                </select> --}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="upzilla">উপজেলা <span class="text-danger">*</span></label>
                <input id="upzilla" type="text" class="form-control{{ $errors->has('district') ? ' is-invalid' : '' }}" name="district" value="{{ old('district', optional($lsCase)->district) }}" autofocus>
                <!-- <select id="upzilla" class="form-control select2" name="upzilla" value="">
                    <option selected disabled>উপজেলা নির্বাচন করুন</option>
                    @foreach ($ports as $port)
                        <option value="{{ $port->id }}" @if (optional($lsCase)->port_id == $port->id) selected @endif>
                            {{ __($port->port_name) }}</option>
                    @endforeach
                </select> -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="moja">মৌজা  নং</label>
                <input id="moja" type="text" class="form-control{{ $errors->has('moja') ? ' is-invalid' : '' }}" name="moja" value="{{ old('moja', optional($lsCase)->moja) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            {{-- {{status}}--}}
            <div class="form-group">
                <label for="status"> স্ট্যাটাস <span class='required-star'>*</span></label>
                <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" autofocus>
                    <option value="" selected disabled>স্ট্যাটাস নির্বাচন করুন</option>
                    <option value="1" @if (optional($lsCase)->status == "1")
                        selected
                        @endif selected>সক্রিয়</option>
                    <option value="0" @if (optional($lsCase)->status == "0")
                        selected
                        @endif>নিষ্ক্রিয়</option>
                </select>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="fileUpload">এল এস কেস ফাইল আপলোড </label>
                <input id="fileUpload" type="file" class="form-control" name="pdf" value="" autofocus>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('manage.ls.case') }}">
            <button type="button" class="btn btn-danger">বাতিল </button>
        </a>
        <button onclick="typeSubmit()" type="submit" class="btn btn-info float-right">সেভ করুন</button>
    </div>
