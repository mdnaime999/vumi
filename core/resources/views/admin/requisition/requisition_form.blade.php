<div class="card-body">
    {{-- <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>তারিখ </label>
                <input type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{ old('date', optional($requisition)->date) }}" autofocus>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <fieldset class="legendary-d mb-3 default_feature_id">
            <div id="requisition_details" data-attr="0">
                <div class="row">
                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label>সিলেক্ট টেন্ডার <span class="text-danger">*</span></label>
                            <select name="tender_id" class="form-control select2" onchange="getProductStock(this.value)" required autofocus>
                                <option value="" disabled selected>টেন্ডার সিলেক্ট করুন</option>
                                @foreach ($tenders as $tender)
                                    <option value="{{ $tender->id }}">{{ $tender->tender_number }} - @if($tender->tender_type == 1) ( উন্মুক্ত টেন্ডার ) @elseif($tender->tender_type == 2) ( সরাসরি টেন্ডার ) @endif</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>মালামালের বিবরণ <span class="text-danger">*</span></label>
                            <select name="product_id[]" class="form-control select2 product_id" required autofocus>
                                <option value="" disabled selected>পণ্য সিলেক্ট করুন</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>চাহিদার পরিমাণ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="product_need[]" placeholder="10" required autofocus>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>ইতিপূর্বে সরঃ তারিখ </label>
                            <input type="date" class="form-control" name="previous_date[]" autofocus>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>মন্তব্য </label>
                            <input type="text" class="form-control" name="comment[]" autofocus>
                        </div>
                    </div>
                    <div class="col-md-1 mt-4">
                        <button class="btn btn-sm btn-primary" type="button" onclick="addRequisitionContent()"><i class="fa fa-plus mr-1"></i> </button>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="card-footer">
        <a href="{{ route('manage.requisition') }}">
            <button type="button" class="btn btn-danger">বাতিল</button>
        </a>
        <button type="submit" class="btn btn-info float-right">সাবমিট</button>
    </div>
</div>
