<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="first_name">বন্দর নাম<span class='required-star'>*</span></label>
                <input id="port_name" type="text" class="form-control{{ $errors->has('port_name') ? ' is-invalid' : '' }}" name="port_name" value="{{ old('port_name', optional($port)->port_name) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="district">জেলা <span class='required-star'>*</span></label>
                <input id="district" type="text" class="form-control{{ $errors->has('district') ? ' is-invalid' : '' }}" name="district" value="{{ old('district', optional($port)->district) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="land_area">জমির পরিমাণ</label>
                <input id="land_area" type="text" class="form-control{{ $errors->has('land_area') ? ' is-invalid' : '' }}" name="land_area" value="{{ old('land_area', optional($port)->land_area) }}" autofocus>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="description">বর্ণনা</label>
                <textarea id="description" col="5" rows="5" name="description" type="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description', optional($port)->description) }}</textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="status"> স্ট্যাটাস <span class='required-star'>*</span></label>
                <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" autofocus>
                    <option value="" selected disabled>স্ট্যাটাস নির্বাচন করুন</option>
                    <option value="1" @if (optional($port)->status == "1") selected @endif selected>সক্রিয়</option>
                    <option value="0" @if (optional($port)->status == "0") selected @endif>নিষ্ক্রিয়</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('view_port') }}">
            <button type="button" class="btn btn-danger">বাতিল</button>
        </a>
        <button onclick="portsubmit()" type="submit" class="btn btn-info float-right">সেভ করুন</button>
    </div>
</div>
