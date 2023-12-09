<div>
    {{-- <form method="POST" wire:submit.prevent="submit" id="frmCheckout" enctype="multipart/form-data" role="form">
        @csrf --}}
        {{-- @include('admin.port.port_form') --}}
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="goods_receipt_order_no">মালামাল প্রাপ্তির আদেশ নং <span class='required-star'>*</span></label>
                        <textarea id="goods_receipt_order_no" type="text" class="form-control" name="goods_receipt_order_no" wire:model='goods_receipt_order_no' placeholder="মালামাল প্রাপ্তির আদেশ নং" autofocus></textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description_of_goods">মালামাল বিবরণ <span class='required-star'>*</span></label>
                        <textarea id="description_of_goods" type="text" class="form-control" cols="8" rows="5" name="description_of_goods" wire:model='description_of_goods' placeholder="মালামাল বিবরণ" autofocus></textarea>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label for="land_price">মালামাল এর পরিমান</label>
                        <input id="land_price" type="text" step="0.0000001" class="form-control" name="land_price" wire:model='land_price' placeholder="মালামাল এর পরিমান" autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="total_land">নামজারি ফাইল</label>
                        <input type="file" class="form-control" accept="application/pdf, image/jpeg, image/png, image/JPEG,image, image/jpg, image/JPG, image/PNG" style="margin-top: 5px" placeholder="Phone Number" wire:model='namjari_file'/>
                        @error('namjari_file') <span class="text-danger">{{ $message }}</span> @enderror
                        @if($namjari_file)<iframe width="100%" height="250" src="{{ $namjari_file->temporaryUrl() }}"> </iframe>@endif
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="description">বর্ণনা</label>
                        <textarea id="description" col="5" rows="5" name="description" type="description" class="form-control" name="description"></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status"> স্ট্যাটাস <span class='required-star'>*</span></label>
                        <select id="status" class="form-control" name="status" autofocus>
                            <option value="">স্ট্যাটাস নির্বাচন করুন</option>
                            <option value="1">সক্রিয়</option>
                            <option value="0">নিষ্ক্রিয়</option>
                        </select>
                    </div>
                </div>
            </div> --}}
            <div class="card-footer">
                <a href="{{ route('view_port') }}">
                    <button type="button" class="btn btn-danger">বাতিল</button>
                </a>
                <button wire:click='portsubmit' type="submit" class="btn btn-info float-right">সেভ করুন</button>
            </div>
        </div>
    {{-- </form> --}}
</div>
