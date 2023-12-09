<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">নাম <span class="text-danger">*</span></label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', optional($user)->name) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="email">ইমেইল <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', optional($user)->email) }}" autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="phone">মোবাইল <span class="text-danger"></span></label>
                <input id="phone" type="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('name', optional($user)->phone) }}" autofocus>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="form-group">
                <label>পদবী <span class="text-danger">*</span></label>
                <select name="designation_id" class="form-control">
                    <option value="" disabled selected>সিলেক্ট পদবী</option>
                    @foreach ($designations as $designation)
                        <option value="{{ $designation->id }}" @if(optional($user)->designation_id == $designation->id) selected @endif>{{ $designation->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>বিভাগ <span class="text-danger">*</span></label>
                <select name="department_id" class="form-control">
                    <option value="" disabled selected>সিলেক্ট বিভাগ</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @if(optional($user)->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="room_desk">রুম নং/ডেস্ক নং <span class="text-danger"></span></label>
                <input id="room_desk" type="text" class="form-control{{ $errors->has('room_desk') ? ' is-invalid' : '' }}" name="room_desk" value="{{ old('room_desk', optional($user)->room_desk) }}" autofocus>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="form-group">
                <label for="type">ব্যবহারকারীর ধরণ <span class="text-danger">*</span></label>
                <select name="type" id="type" class="form-control">
                    <option value="" disabled selected>সিলেক্ট ব্যবহারকারীর ধরণ</option>
                    <option value="admin" @if(optional($user)->type == "admin") selected @endif>Admin</option>
                    <option value="user" @if(optional($user)->type == "user") selected @endif>User</option>
                    <option value="manager" @if(optional($user)->type == "manager") selected @endif>Manager</option>
                </select>
            </div>
        </div> --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="role">বিভাগ/পদবী/অনুমতি <span class="text-danger">*</span></label>
                <select name="role_id" id="role_id" class="form-control select2">
                    <option value="" disabled selected>বিভাগ/পদবী/অনুমতি নির্বাচন করুন</option>
                    @foreach($permissions as $permission)
                        <option value="{{$permission->id}}" @if(optional($user)->role_id == $permission->id) selected @endif>{{ $permission->departments->name ?? '' }} - {{ $permission->designations->name ?? '' }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 @if($user) d-none @endif">
            <div class="form-group">
                <label for="password">পাসওয়ার্ড <span class="text-danger">*</span></label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password', optional($user)->password) }}" autofocus>

            </div>
        </div>
        <div class="col-md-4 @if($user) d-none @endif">
            <div class="form-group">
                <label for="confirm_password">নিশ্চিত করুন পাসওয়ার্ড <span class="text-danger">*</span></label>
                <input id="confirm_password" type="password" class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" name="confirm_password" value="{{ old('confirm_password', optional($user)->confimr_password) }}" autofocus>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="image">ইমেজ</label>

                <div class="input-group mb-1">
                    <div class="custom-file">
                        <input type="file" value="{{ optional($user)->image }}" name="image" id="image" class="form-control-file{{ $errors->has('image') ? ' is-invalid' : '' }}" accept="image/jpeg, image/png" onchange="imageUpload(this, 'show_photo')">
                        <label class="custom-file-label" for="image">সিলেক্ট ফাইল</label>
                    </div>
                </div>
                <small id="emailHelp" class="form-text text-muted">
                    File Format: *.jpg/ .png | Max file size: 3MB
                </small>
                <div class="mb-1">
                    {!! App\Libraries\CommonFunction::getImageFromURL(optional($user)->image, '', 'show_photo') !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="status"> স্ট্যাটাস <span class="text-danger"></span></label>
                <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" autofocus>
                    <option value="" selected disabled>সিলেক্ট স্ট্যাটাস</option>
                    <option value="1" @if (optional($user)->status == "1")
                        selected
                        @endif selected>Active</option>
                    <option value="0" @if (optional($user)->status == "0")
                        selected
                        @endif>De-active</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('view_users') }}">
            <button type="button" class="btn btn-danger">ক্লোজ</button>
        </a>
        <button onclick="usersubmit()" type="submit" class="btn btn-info float-right">সাবমিট</button>
    </div>
</div>
