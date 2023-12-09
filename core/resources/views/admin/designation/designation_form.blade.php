<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label> সিলেক্ট বিভাগ <span class="text-danger">*</span></label>
                <select name="department_id" class="form-control" required autofocus>
                    <option value="" selected disabled>বিভাগ সিলেক্ট করুন</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @if (optional($designation)->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>নাম <span class="text-danger">*</span></label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', optional($designation)->name) }}" autofocus>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> স্ট্যাটাস <span class="text-danger">*</span></label>
                <select name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" autofocus>
                    <option value="" selected disabled>স্ট্যাটাস নির্বাচন করুন</option>
                    <option value="1" @if (optional($designation)->status == "1") selected @endif>সক্রিয়</option>
                    <option value="0" @if (optional($designation)->status == "0") selected @endif>নিষ্ক্রিয়</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('manage.designation') }}">
            <button type="button" class="btn btn-danger">বাতিল </button>
        </a>
        <button type="submit" class="btn btn-info float-right">সেভ করুন</button>
    </div>
</div>
