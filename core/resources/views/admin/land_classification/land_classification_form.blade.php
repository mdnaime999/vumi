<div class="card-body">
    <div class="row">
        <div class="col-md-7">
            <div class="form-group">
                <label for="name">নাম <span class='required-star'>*</span></label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', optional($classification)->name) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="status"> স্ট্যাটাস <span class='required-star'>*</span></label>
                <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" autofocus>
                    <option value="" selected disabled>স্ট্যাটাস নির্বাচন করুন</option>
                    <option value="1" @if (optional($classification)->status == "1")
                        selected
                        @endif selected>সক্রিয়</option>
                    <option value="0" @if (optional($classification)->status == "0")
                        selected
                        @endif>নিষ্ক্রিয়</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('manage.land.classification') }}">
            <button type="button" class="btn btn-danger">বাতিল </button>
        </a>
        <button onclick="classificationSubmit()" type="submit" class="btn btn-info float-right">সেভ করুন</button>
    </div>
</div>
