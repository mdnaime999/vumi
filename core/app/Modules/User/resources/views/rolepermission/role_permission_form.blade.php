<div class="card-body">
    <div class="row">
        {{-- <div class="col-md-4">
            <div class="form-group">
                <label for="name">রোল নাম <span class='required-star'></span></label>
                <input id="name" type="text" required class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', optional($permission)->name) }}" autofocus>
            </div>
        </div> --}}
        <div class="col-md-3">
            <div class="form-group">
                <label>সিলেক্ট বিভাগ <span class="text-danger">*</span></label>
                <select name="department_id" class="form-control select2" onchange="getDesignationForRole(this.value)" required autofocus>
                    <option value="" disabled selected>বিভাগ সিলেক্ট করুন</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @if(optional($permission)->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>সিলেক্ট পদবী <span class="text-danger">*</span></label>
                <select name="designation_id" class="form-control select2 designation_id" required autofocus>
                    <option value="" disabled selected>পদবী সিলেক্ট করুন</option>
                    @foreach ($designations as $designation)
                        <option value="{{ $designation->id }}" @if(optional($permission)->designation_id == $designation->id) selected @endif>{{ $designation->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div id="userAccess">
        <div class="row">
            <div class="col-md-12 text-center text-white">
                <div>
                    <h2>রোল ম্যানেজমেন্ট</h2>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
                <input type="checkbox" onclick="checkAll()" id="selectAll"> <strong style="font-size: 16px;">সব সিলেক্ট</strong>
            </div>
        </div>
        <div class="row" id="accessRow">
            <div class="col-md-3">
                <div class="group">
                    <input type="checkbox" id="administration" class="group-head" onclick="onClickGroupHeads()"> <strong>ম্যানেজমেন্ট</strong>
                    <ul ref="administration">
                        <li class="pb-2"><input type="checkbox" class="access group-head" onclick="onClickGroupHeads()" value="user/view_users" name="access[]" @if($permission !=null) @if (array_search("user/view_users", $access)> -1) checked @endif @endif> ব্যবহারকারী ম্যানেজ
                            <ul>
                                <li><input type="checkbox" class="access" value="user/add_user" name="access[]" @if($permission !=null) @if (array_search("user/add_user", $access)> -1) checked @endif @endif> যোগ করুন &nbsp
                                <input type="checkbox" class="access" value="user/edit_user" name="access[]" @if($permission !=null) @if (array_search("user/edit_user", $access)> -1) checked @endif @endif> আপডেট করুন &nbsp
                                <input type="checkbox" class="access" value="user/delete_user" name="access[]" @if($permission !=null) @if (array_search("user/delete_user", $access)> -1) checked @endif @endif> অপসারণ</li>
                            </ul>
                        </li>
                        <li class="pb-2"><input type="checkbox" class="access group-head" onclick="onClickGroupHeads()" value="user/view_role_permissions" name="access[]" @if($permission !=null) @if (array_search("user/view_role_permissions", $access)> -1) checked @endif @endif> রোল ম্যানেজমেন্ট ম্যানেজ
                            <ul>
                                <li><input type="checkbox" class="access" value="user/add_role_permission" name="access[]" @if($permission !=null) @if (array_search("user/add_role_permission", $access)> -1) checked @endif @endif> যোগ করুন &nbsp
                                <input type="checkbox" class="access" value="user/edit_role_permission" name="access[]" @if($permission !=null) @if (array_search("user/edit_role_permission", $access)> -1) checked @endif @endif> আপডেট করুন &nbsp
                                <input type="checkbox" class="access" value="user/delete_role_permission" name="access[]" @if($permission !=null) @if (array_search("user/delete_role_permission", $access)> -1) checked @endif @endif> অপসারণ</li>
                            </ul>
                        </li>
                        <li class="pb-2"><input type="checkbox" class="access group-head" onclick="onClickGroupHeads()" value="admin/manage/department" name="access[]" @if($permission !=null) @if (array_search("admin/manage/department", $access)> -1) checked @endif @endif> বিভাগ ম্যানেজ
                            <ul>
                                <li><input type="checkbox" class="access" value="admin/add/department" name="access[]" @if($permission !=null) @if (array_search("admin/add/department", $access)> -1) checked @endif @endif> যোগ করুন &nbsp
                                <input type="checkbox" class="access" value="admin/edit/department" name="access[]" @if($permission !=null) @if (array_search("admin/edit/department", $access)> -1) checked @endif @endif> আপডেট করুন &nbsp
                                <input type="checkbox" class="access" value="admin/delete/department" name="access[]" @if($permission !=null) @if (array_search("admin/delete/department", $access)> -1) checked @endif @endif> অপসারণ</li>
                            </ul>
                        </li>
                        <li class="pb-2"><input type="checkbox" class="access group-head" onclick="onClickGroupHeads()" value="admin/manage/designation" name="access[]" @if($permission !=null) @if (array_search("admin/manage/designation", $access)> -1) checked @endif @endif> পদবী ম্যানেজ
                            <ul>
                                <li><input type="checkbox" class="access" value="admin/add/designation" name="access[]" @if($permission !=null) @if (array_search("admin/add/designation", $access)> -1) checked @endif @endif> যোগ করুন &nbsp
                                <input type="checkbox" class="access" value="admin/edit/designation" name="access[]" @if($permission !=null) @if (array_search("admin/edit/designation", $access)> -1) checked @endif @endif> আপডেট করুন &nbsp
                                <input type="checkbox" class="access" value="admin/delete/designation" name="access[]" @if($permission !=null) @if (array_search("admin/delete/designation", $access)> -1) checked @endif @endif> অপসারণ</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="group">
                    <input type="checkbox" id="product" class="group-head" onclick="onClickGroupHeads()"> <strong>বন্দর</strong>
                    <ul ref="product">
                        <li><input type="checkbox" class="access" value="admin/view_ports" name="access[]" @if($permission !=null) @if (array_search("admin/view_ports", $access)> -1) checked @endif @endif> বন্দর ম্যানেজ</li>
                        <li><input type="checkbox" class="access" value="admin/add_port" name="access[]" @if($permission !=null) @if (array_search("admin/add_port", $access)> -1) checked @endif @endif> বন্দর যোগ করুন</li>
                        <li><input type="checkbox" class="access" value="admin/edit_port" name="access[]" @if($permission !=null) @if (array_search("admin/edit_port", $access)> -1) checked @endif @endif> বন্দর আপডেট করুন</li>
                        <li><input type="checkbox" class="access" value="admin/delete_port" name="access[]" @if($permission !=null) @if (array_search("admin/delete_port", $access)> -1) checked @endif @endif> বন্দর অপসারণ</li>
                        <br>
                        <li><input type="checkbox" class="access" value="admin/manage/land/classification" name="access[]" @if($permission !=null) @if (array_search("admin/manage/land/classification", $access)> -1) checked @endif @endif> জমির শ্রেণীবিভাগ ম্যানেজ</li>
                        <li><input type="checkbox" class="access" value="admin/add/land/classification" name="access[]" @if($permission !=null) @if (array_search("admin/add/land/classification", $access)> -1) checked @endif @endif> জমির শ্রেণীবিভাগ যোগ করুন</li>
                        <li><input type="checkbox" class="access" value="admin/edit/land/classification" name="access[]" @if($permission !=null) @if (array_search("admin/edit/land/classification", $access)> -1) checked @endif @endif> জমির শ্রেণীবিভাগ আপডেট করুন</li>
                        <li><input type="checkbox" class="access" value="admin/delete/land/classification" name="access[]" @if($permission !=null) @if (array_search("admin/delete/land/classification", $access)> -1) checked @endif @endif> জমির শ্রেণীবিভাগ অপসারণ</li>
                        <br>
                        <li><input type="checkbox" class="access" value="admin/manage/land/type" name="access[]" @if($permission !=null) @if (array_search("admin/manage/land/type", $access)> -1) checked @endif @endif> জমির ধরন ম্যানেজ</li>
                        <li><input type="checkbox" class="access" value="admin/add/land/type" name="access[]" @if($permission !=null) @if (array_search("admin/add/land/type", $access)> -1) checked @endif @endif> জমির ধরন যোগ করুন</li>
                        <li><input type="checkbox" class="access" value="admin/edit/land/type" name="access[]" @if($permission !=null) @if (array_search("admin/edit/land/type", $access)> -1) checked @endif @endif> জমির ধরন আপডেট করুন</li>
                        <li><input type="checkbox" class="access" value="admin/delete/land/type" name="access[]" @if($permission !=null) @if (array_search("admin/delete/land/type", $access)> -1) checked @endif @endif> জমির ধরন অপসারণ</li>
                        <br>
                        <li><input type="checkbox" class="access" value="admin/manage/ls/case" name="access[]" @if($permission !=null) @if (array_search("admin/manage/ls/case", $access)> -1) checked @endif @endif> এল এ কেস নং ম্যানেজ</li>
                        <li><input type="checkbox" class="access" value="admin/add/ls/case" name="access[]" @if($permission !=null) @if (array_search("admin/add/ls/case", $access)> -1) checked @endif @endif> এল এ কেস নং যোগ করুন</li>
                        <li><input type="checkbox" class="access" value="admin/edit/ls/case" name="access[]" @if($permission !=null) @if (array_search("admin/edit/ls/case", $access)> -1) checked @endif @endif> এল এ কেস নং আপডেট করুন</li>
                        <li><input type="checkbox" class="access" value="admin/delete/ls/case" name="access[]" @if($permission !=null) @if (array_search("admin/delete/ls/case", $access)> -1) checked @endif @endif> এল এ কেস নং অপসারণ</li>
                        <br>
                        <li><input type="checkbox" class="access" value="admin/manage/tofsil" name="access[]" @if($permission !=null) @if (array_search("admin/manage/tofsil", $access)> -1) checked @endif @endif> তফসিল ম্যানেজ</li>
                        <li><input type="checkbox" class="access" value="admin/add/tofsil" name="access[]" @if($permission !=null) @if (array_search("admin/add/tofsil", $access)> -1) checked @endif @endif> তফসিল যোগ করুন</li>
                        <li><input type="checkbox" class="access" value="admin/edit/tofsil" name="access[]" @if($permission !=null) @if (array_search("admin/edit/tofsil", $access)> -1) checked @endif @endif> তফসিল আপডেট করুন</li>
                        <li><input type="checkbox" class="access" value="admin/delete/tofsil" name="access[]" @if($permission !=null) @if (array_search("admin/delete/tofsil", $access)> -1) checked @endif @endif> তফসিল অপসারণ</li>
                        <br>
                        <li><input type="checkbox" class="access" value="admin/manage/establishment" name="access[]" @if($permission !=null) @if (array_search("admin/manage/establishment", $access)> -1) checked @endif @endif> স্থাপনা ম্যানেজ</li>
                        <li><input type="checkbox" class="access" value="admin/add/establishment" name="access[]" @if($permission !=null) @if (array_search("admin/add/establishment", $access)> -1) checked @endif @endif> স্থাপনা যোগ করুন</li>
                        <li><input type="checkbox" class="access" value="admin/edit/establishment" name="access[]" @if($permission !=null) @if (array_search("admin/edit/establishment", $access)> -1) checked @endif @endif> স্থাপনা আপডেট করুন</li>
                        <li><input type="checkbox" class="access" value="admin/delete/establishment" name="access[]" @if($permission !=null) @if (array_search("admin/delete/establishment", $access)> -1) checked @endif @endif> স্থাপনা অপসারণ</li>
                        <br>
                        <li><input type="checkbox" class="access" value="admin/manage/port/report" name="access[]" @if($permission !=null) @if (array_search("admin/manage/port/report", $access)> -1) checked @endif @endif> বন্দর শিট</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="group">
                    <input type="checkbox" id="product" class="group-head" onclick="onClickGroupHeads()"> <strong>পণ্য স্টক (মজুদ)</strong>
                    <ul ref="product">
                        <li><input type="checkbox" class="access" value="admin/manage/product/stock" name="access[]" @if($permission !=null) @if (array_search("admin/manage/product/stock", $access)> -1) checked @endif @endif> পণ্য স্টক (মজুদ)</li>
                        <li><input type="checkbox" class="access" value="admin/add/product/stock" name="access[]" @if($permission !=null) @if (array_search("admin/add/product/stock", $access)> -1) checked @endif @endif> পণ্য স্টক (মজুদ) যোগ করুন</li>
                        <li><input type="checkbox" class="access" value="admin/edit/product/stock" name="access[]" @if($permission !=null) @if (array_search("admin/edit/product/stock", $access)> -1) checked @endif @endif> পণ্য স্টক (মজুদ) আপডেট করুন</li>
                        <li><input type="checkbox" class="access" value="admin/delete/product/stock" name="access[]" @if($permission !=null) @if (array_search("admin/delete/product/stock", $access)> -1) checked @endif @endif> পণ্য স্টক (মজুদ) অপসারণ</li>
                        <br>
                        <li><input type="checkbox" class="access" value="admin/manage/product/stock/info" name="access[]" @if($permission !=null) @if (array_search("admin/manage/product/stock/info", $access)> -1) checked @endif @endif> স্টক (মজুদ) তথ্য</li>
                        <br>
                        <li><input type="checkbox" class="access" value="admin/user/stock/info" name="access[]" @if($permission !=null) @if (array_search("admin/user/stock/info", $access)> -1) checked @endif @endif> ব্যবহারকারীর স্টক (মজুদ) তথ্য</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="group">
                    <input type="checkbox" id="slider" class="group-head" onclick="onClickGroupHeads()"> <strong>স্টেশনারী চাহিদা</strong>
                    <ul ref="slider">
                        <li><input type="checkbox" class="access" value="admin/manage/requisition" name="access[]" @if($permission != null) @if (array_search("admin/manage/requisition", $access)> -1) checked @endif @endif> স্টেশনারী চাহিদা ম্যানেজ</li>
                        <li><input type="checkbox" class="access" value="admin/add/requisition" name="access[]" @if($permission != null) @if (array_search("admin/add/requisition", $access)> -1) checked @endif @endif> স্টেশনারী চাহিদা যোগ করুন</li>
                        <li><input type="checkbox" class="access" value="admin/edit/requisition" name="access[]" @if($permission != null) @if (array_search("admin/edit/requisition", $access)> -1) checked @endif @endif> স্টেশনারী চাহিদা আপডেট করুন</li>
                        <li><input type="checkbox" class="access" value="admin/delete/requisition" name="access[]" @if($permission != null) @if (array_search("admin/delete/requisition", $access)> -1) checked @endif @endif> স্টেশনারী চাহিদা অপসারণ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('view_role_permissions') }}">
            <button type="button" class="btn btn-danger">ক্লোজ</button>
        </a>
        <button onclick="permissionsubmit()" type="submit" class="btn btn-info float-right">সাবমিট</button>
    </div>
</div>

<style>
    .group ul li,
    .group {
        color: #000 !important;
        list-style: none;
    }
</style>
