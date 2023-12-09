<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="l_s_case_id">এল এ কেস নং<span class="text-danger">*</span></label>
                <select id="l_s_case_id" class="form-control select2bs4" name="l_s_case_id" value="">
                    <option selected disabled>এল এ কেস নির্বাচন করুন</option>
                    @foreach ($lsCases as $lsCase)
                        <option value="{{ $lsCase->id }}" @if (optional($establishment)->l_s_case_id == $lsCase->id) selected @endif>
                            {{ __($lsCase->number) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">স্থাপনা নাম<span class='required-star'>*</span></label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', optional($establishment)->name) }}" autofocus>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form-group">
                <label for="details">বিস্তারিত</label>
                <textarea rows="10" cols="10" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }} "  name="details" style="height:100%;">{{ old('details', optional($establishment)->details) }}</textarea>
            </div>
        </div> --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="floor_num">ফ্লোর নম্বর</label>
                <input id="floor_num" type="text" class="form-control{{ $errors->has('floor_num') ? ' is-invalid' : '' }}" name="floor_num" value="{{ old('floor_num', optional($establishment)->floor_num) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="room_num">রুম নম্বর</label>
                <input id="room_num" type="text" class="form-control{{ $errors->has('room_num') ? ' is-invalid' : '' }}" name="room_num" value="{{ old('room_num', optional($establishment)->room_num) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            {{-- {{status}}--}}
            <div class="form-group">
                <label for="status"> স্ট্যাটাস <span class='required-star'>*</span></label>
                <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" autofocus>
                    <option value="" selected disabled>স্ট্যাটাস নির্বাচন করুন</option>
                    <option value="1" @if (optional($establishment)->status == "1")
                        selected
                        @endif selected>সক্রিয়</option>
                    <option value="0" @if (optional($establishment)->status == "0")
                        selected
                        @endif>নিষ্ক্রিয়</option>
                </select>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('manage.establishment') }}">
            <button type="button" class="btn btn-danger">বাতিল </button>
        </a>
        <button onclick="typeSubmit()" type="submit" class="btn btn-info float-right">সেভ করুন</button>
    </div>
