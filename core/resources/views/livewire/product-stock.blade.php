<div>
    <form wire:submit.prevent="saveProductStock">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label> সিলেক্ট স্থলবন্দর <span class="text-danger">*</span></label>
                        <select wire:model="port_id" class="form-control @error('port_id') is-invalid @enderror" autofocus>
                            <option value="" selected>স্থলবন্দর সিলেক্ট করুন</option>
                            @foreach ($ports as $port)
                                <option value="{{ $port->id }}">{{ $port->port_name }}</option>
                            @endforeach
                        </select>
                        @error('port_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> টেন্ডারের ধরণ <span class="text-danger">*</span></label>
                        <select class="form-control @error('tender_type') is-invalid @enderror" wire:model="tender_type" autofocus>
                            <option value="" selected>টেন্ডারের ধরণ নির্বাচন করুন</option>
                            <option value="1">উন্মুক্ত টেন্ডার</option>
                            <option value="2">সরাসরি টেন্ডার</option>
                        </select>
                        @error('tender_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> টেন্ডার নাম্বার </label>
                        <input type="text" class="form-control @error('tender_number') is-invalid @enderror" wire:model="tender_number" value="" placeholder="টেন্ডার নাম্বার" autofocus>
                        @error('tender_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> সম্পদের ধরণ <span class="text-danger">*</span></label>
                        <select class="form-control @error('asset_type') is-invalid @enderror" wire:model="asset_type" autofocus>
                            <option value="" selected>সম্পদের ধরণ নির্বাচন করুন</option>
                            <option value="1">অফিস সরঞ্জাম</option>
                            <option value="2">স্টাশনারী</option>
                        </select>
                        @error('asset_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> সকল সম্পদের মূল্য <span class="text-gray">(optional)</span> </label>
                        <input type="text" class="form-control" wire:model="total_price" value="" placeholder="১০০০০" autofocus>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> সকল পণ্য ক্রয়ের তারিখ <span class="text-gray">(optional)</span> </label>
                        <input type="date" class="form-control" wire:model="all_date" value="" autofocus>
                    </div>
                </div>
                @foreach ($products as $key => $item)
                    <fieldset class="legendary-d mb-3 default_stock_id">
                        <div data-attr="0">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label> সম্পদের নাম <span class="text-danger">*</span></label>
                                        <input type="text" name="itemInputsport_name"
                                            class="form-control @error('products.{{$key}}.product_name') is-invalid @enderror" list="browsers" wire:model="products.{{$key}}.product_name"
                                            placeholder="সম্পদ খুজুন" autocomplete="off" wire:click='productNameInput({{$key}})'
                                            wire:keydown.escape='resetProduct' wire:keydown.tab='resetProduct'
                                            wire:keydown.Arrow-Up="decrementHighlightCountry" wire:keydown.Arrow-Down="incrementHighlightCountry"
                                            wire:keydown.enter="portEnter" />
                                        @error('products.{{$key}}.product_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @if ($checkProduct == 1 && $keyCheck == $key)
                                            <div class="card toContact" style="width: 94%; display: flex; flex-basis: auto; flex-direction: column;  flex-grow: 1;  overflow: hidden; position: absolute; z-index: 99999;">
                                                @if (count($productData) > 0)
                                                    @foreach ($productData as $item)
                                                        <a class="list-group-item" wire:click='searchProduct({{ $item->id }}, {{ $key }})' style="cursor: pointer;" onmouseover='this.style.textDecoration="underline"' onmouseout='this.style.textDecoration="none"'>{{ $item->name }}</a>
                                                    @endforeach
                                                @else
                                                    <div class="list-group-item">কোন ফলাফল নেই</div>
                                                @endif
                                                <a href="javascript:void(0);" class="card-link text-center p-2" wire:click="newProduct({{ $key }})">+ নতুন সম্পদ যোগ করুন</a>
                                            </div>
                                        @endif
                                        @if ($newProduct == 1 && $keyCheck2 == $key)
                                            <div class="card toContact" style="width: 94%; display: flex; flex-basis: auto; flex-direction: column;  flex-grow: 1;  overflow: hidden; position: absolute; z-index: 99999;" aria-hidden="true">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="first_name">সম্পদের নাম<span class="text-danger">*</span></label>
                                                            <input type="text" autocomplete="off" class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="পেন্সিল" wire:model='name' />
                                                            @error('name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="f-right" style="margin-top: 5px">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger" wire:click="newProductCencel({{ $key }})">বাতিল করুন</a>
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary" wire:click="productSave({{ $key }})">যোগ করুন</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>সম্পদের সংখ্যা <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('stock') is-invalid @enderror" wire:model="products.{{$key}}.stock" value="" placeholder="১০" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> সম্পদের ধরণ </label>
                                        <select class="form-control" wire:model="products.{{$key}}.type" autofocus>
                                            <option value="" selected>সম্পদের ধরণ নির্বাচন করুন</option>
                                            <option value="5">সংখ্যা</option>
                                            <option value="1">প্যাঃ</option>
                                            <option value="2">বক্স</option>
                                            <option value="3">রোল</option>
                                            <option value="4">বোতল</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> সম্পদের মূল্য </label>
                                        <input type="text" class="form-control" wire:model="products.{{$key}}.price" value="" placeholder="১০০০" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label> ক্রয়ের তারিখ </label>
                                        <input type="date" class="form-control" wire:model="products.{{$key}}.date" value="" autofocus>
                                    </div>
                                </div>
                                @if ($assetTypeCheck == 1)
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label> ওয়ারেন্টি তারিখ </label>
                                            <input type="date" class="form-control" wire:model="products.{{$key}}.warranty_date" value="" autofocus>
                                        </div>
                                    </div>
                                @endif
                                @if ($key == 0)
                                    <div class="col-md-1 mt-4 without_warranty_button">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary" wire:click="addProductStockContent()"><i class="fa fa-plus mr-1"></i> </a>
                                    </div>
                                @else
                                    <div class="col-md-1 mt-4">
                                        <button class="btn btn-danger" type="button" wire:click="deleteProductStockContent({{ $key }})"><i class="fa fa-trash"></i></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </fieldset>
                @endforeach
            </div>
            <div class="card-footer">
                <a href="{{ route('manage.product.stock') }}">
                    <button type="button" class="btn btn-danger">বাতিল </button>
                </a>
                <button type="submit" class="btn btn-info float-right">সেভ করুন</button>
            </div>
        </div>
    </form>
</div>
