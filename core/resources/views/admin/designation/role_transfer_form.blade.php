<div class="card-body">
    <div class="row">
        @if(Auth::guard('web')->user()->type == 'superadmin')
            <div class="col-md-4">
                <div class="form-group">
                    <label>বিভাগ <span class="text-danger">*</span></label>
                    <select name="department_id" class="form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}" autofocus onchange="getDesignationForRole(this.value)">
                        <option value="" selected disabled>বিভাগ সিলেক্ট করুন</option>
                        @if($departments)
                            @foreach ($departments as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        @endif
        <div class="col-md-4">
            <div class="form-group">
                <label>পদবি এবং নাম<span class="text-danger">*</span></label>
                <select name="role_id" class="form-control {{ $errors->has('role_id') ? ' is-invalid' : '' }} designation_id" autofocus>
                    <option value="" disabled selected>পদবী সিলেক্ট করুন</option>
                        @if($designations)
                            @foreach ($designations as $designation)
                                @foreach ($designation->roles as $roleD)
                                    @foreach ($roleD->users as $userName)
                                        <option value="{{ $userName->id }}/{{ $roleD->id }}"> {{ $userName->name }} - {{ $designation->name }}</option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endif
                </select>
            </div>
        </div>
        @if(Auth::guard('web')->user()->type == 'superadmin')
            <div class="col-md-4">
                <div class="form-group">
                    <label for="role">বিভাগ/পদবী/ট্রান্সফার <span class="text-danger">*</span></label>
                    <select name="permission_id" id="permission_id" class="form-control">
                        <option value="" disabled selected>বিভাগ/পদবী/অনুমতি নির্বাচন করুন</option>
                        @foreach($permissions as $permission)
                            <option value="{{$permission->id}}">{{ $permission->departments->name ?? '' }} - {{ $permission->designations->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        <div class="col-md-4">
            <div class="form-group">
                <label>তারিখ থেকে <span class="text-danger">*</span></label>
                <input type="date" class="form-control{{ $errors->has('t_from_date') ? ' is-invalid' : '' }}" name="t_from_date"
                    value="" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>তারিখ পর্যন্ত<span class="text-danger">*</span></label>
                <input type="date" class="form-control{{ $errors->has('t_to_date') ? ' is-invalid' : '' }}" name="t_to_date"
                    value="" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> স্ট্যাটাস <span class="text-danger">*</span></label>
                <select name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" autofocus>
                    <option value="1">সক্রিয়</option>
                    <option value="0">নিষ্ক্রিয়</option>
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
