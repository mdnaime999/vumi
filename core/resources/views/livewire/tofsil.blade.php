<div>
    <div class="grid-auto  mb-6 " wire:click="@if ($checkLandType == 1) resetLandType @elseif($checkClass == 1) resetClass @endif">
        <div class="card-body">
            <div class="row">
                {{-- <input type="hidden" value="{{ $lsCaseId }}" wire:model='ls_case_id'> --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="kotian_no">খতিয়ান নং <span class='required-star'>*</span></label>
                        <input id="kotian_no" type="text" class="form-control @error('kotian_no') is-invalid @enderror" name="kotian_no" value=""
                            wire:model='kotian_no' placeholder="খতিয়ান নং লিখুন" autofocus>
                        @error('kotian_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dag_no">দাগ নং(এস. এ) <span class='required-star'>*</span></label>
                        <input id="dag_no" type="text" class="form-control @error('dag_no') is-invalid @enderror" name="dag_no" value=""
                            wire:model='dag_no' placeholder="দাগ নং(এস. এ) লিখুন" autofocus>
                        @error('dag_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="classified_type_id">জমি শ্রেণী (এস. এ)<span class="text-danger">*</span></label>
                        {{-- <select id="classified_type_id" class="form-control select2bs4" name="classified_type_id"
                        value="" wire:model='classified_type_id'>
                        <option selected disabled>জমির শ্রেণী নির্বাচন করুন</option>
                        @foreach ($classifications as $classification)
                            <option value="{{ $classification->id }}" @if (optional($tofsil)->classified_type_id == $classification->id) selected @endif>
                                {{ __($classification->name) }}</option>
                        @endforeach
                    </select> --}}

                        <input type="text" name="itemInputsport_name"
                            class="form-control @error('classified_type_id') is-invalid @enderror" list="browsers"
                            wire:model='classified_type_id' placeholder="জমির শ্রেণী খুজুন" autocomplete="off"
                            wire:click='classNameInput' wire:keydown.escape='resetPort' wire:keydown.tab='resetPoret'
                            wire:keydown.Arrow-Up="decrementHighlightCountry"
                            wire:keydown.Arrow-Down="incrementHighlightCountry" wire:keydown.enter="portEnter" />
                        @error('classified_type_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @if ($checkClass == 1)
                            <div class="card toContact"
                                style="width: 94%; display: flex; flex-basis: auto; flex-direction: column;  flex-grow: 1;  overflow: hidden; position: absolute; z-index: 99999;">
                                @if (count($classifications) > 0)
                                    @foreach ($classifications as $item)
                                        <a class="list-group-item" wire:click='searchClass({{ $item->id }})'
                                            style="cursor: pointer;" onmouseover='this.style.textDecoration="underline"'
                                            onmouseout='this.style.textDecoration="none"'>{{ $item->name }}</a>
                                    @endforeach
                                @else
                                    <div class="list-group-item">No Result</div>
                                @endif
                                <a href="#" class="card-link text-center p-2" wire:click='newClass'>+ নতুন শ্রেণী
                                    যোগ করুন</a>
                            </div>
                        @endif
                        @if ($newClass == 1)
                            <div class="card toContact"
                                style="width: 94%; display: flex; flex-basis: auto; flex-direction: column;  flex-grow: 1;  overflow: hidden; position: absolute; z-index: 99999;"
                                aria-hidden="true">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="first_name">শ্রেণী নাম<span
                                                    class='required-star'>*</span></label>
                                            <input type="text" autocomplete="off"
                                                class="form-control mb-2 @error('class_name') is-invalid @enderror"
                                                placeholder="শ্রেণী নাম" wire:model='class_name' />
                                            @error('class_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="f-right" style="margin-top: 5px">
                                        <button class="btn btn-sm btn-danger"
                                            wire:click='newClassCencel'>Cencel</button>
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            wire:click='classSave'>Save</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="land_type_id">জমির ধরণ<span class="text-danger">*</span></label>
                        {{-- <select id="land_type_id" class="form-control select2bs4" name="land_type_id" value=""
                            wire:model='land_type_id'>
                            <option selected disabled>জমি শ্রেণী নির্বাচন করুন</option>
                            @foreach ($landTypes as $landType)
                                <option value="{{ $landType->id }}" @if (optional($tofsil)->land_type_id == $landType->id) selected @endif>
                                    {{ __($landType->name) }}</option>
                            @endforeach
                        </select> --}}



                        <input type="text" name="itemInputsport_name"
                            class="form-control @error('land_type_id') is-invalid @enderror" list="browsers"
                            wire:model='land_type_id' placeholder="জমির ধরণ খুজুন" autocomplete="off"
                            wire:click='landTypeNameInput' wire:keydown.escape='resetPort' wire:keydown.tab='resetPoret'
                            wire:keydown.Arrow-Up="decrementHighlightCountry"
                            wire:keydown.Arrow-Down="incrementHighlightCountry" wire:keydown.enter="portEnter" />
                        @error('land_type_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @if ($checkLandType == 1)
                            <div class="card toContact"
                                style="width: 94%; display: flex; flex-basis: auto; flex-direction: column;  flex-grow: 1;  overflow: hidden; position: absolute; z-index: 99999;">
                                @if (count($landTypes) > 0)
                                    @foreach ($landTypes as $item)
                                        <a class="list-group-item" wire:click='searchLandType({{ $item->id }})'
                                            style="cursor: pointer;" onmouseover='this.style.textDecoration="underline"'
                                            onmouseout='this.style.textDecoration="none"'>{{ $item->name }}</a>
                                    @endforeach
                                @else
                                    <div class="list-group-item">No Result</div>
                                @endif
                                <a href="#" class="card-link text-center p-2" wire:click='newLandType'>+ নতুন
                                    যোগ করুন</a>
                            </div>
                        @endif
                        @if ($newLandType == 1)
                            <div class="card toContact"
                                style="width: 94%; display: flex; flex-basis: auto; flex-direction: column;  flex-grow: 1;  overflow: hidden; position: absolute; z-index: 99999;"
                                aria-hidden="true">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="first_name">জমির ধরণ<span
                                                    class='required-star'>*</span></label>
                                            <input type="text" autocomplete="off"
                                                class="form-control mb-2 @error('land_type_name') is-invalid @enderror"
                                                placeholder="জমির ধরণ" wire:model='land_type_name' />
                                            @error('land_type_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="f-right" style="margin-top: 5px">
                                        <button class="btn btn-sm btn-danger"
                                            wire:click='newLandTypeCencel'>Cencel</button>
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            wire:click='landTypeSave'>Save</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="total_land">জমির পরিমাণ(একরে)<span class='required-star'>*</span></label>
                        <input id="total_land" type="text"
                            class="form-control{{ $errors->has('total_land') ? ' is-invalid' : '' }}" name="total_land"
                            value="{{ old('total_land', optional($tofsil)->total_land) }}" wire:model='total_land'
                            placeholder="জমির পরিমাণ(একরে) লিখুন" autofocus>
                        @error('total_land')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="comment">মন্তব্য</label>
                        <input id="comment" type="text"
                            class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment"
                            value="{{ old('comment', optional($tofsil)->comment) }}" wire:model='comment'
                            placeholder="মন্তব্য লিখুন" autofocus>
                    </div>
                </div>
                {{-- <div class="col-md-4"> --}}
                    {{-- {{status}} --}}
                    {{-- <div class="form-group">
                        <label for="status"> স্ট্যাটাস <span class='required-star'>*</span></label>
                        <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"
                            name="status" wire:model='status' autofocus>
                            <option value="" selected disabled>স্ট্যাটাস নির্বাচন করুন</option>
                            <option value="1" @if (optional($tofsil)->status == '1') selected @endif selected>সক্রিয়
                            </option>
                            <option value="0" @if (optional($tofsil)->status == '0') selected @endif>নিষ্ক্রিয়
                            </option>
                        </select>

                    </div> --}}
                {{-- </div> --}}
            </div>
            <div class="card-footer">
                <a href="{{ route('manage.tofsil') }}">
                    <button type="button" class="btn btn-danger">বাতিল </button>
                </a>
                <button onclick="typeSubmit()" type="submit" class="btn btn-info float-right" wire:click='tofsilSave'>সেভ করুন</button>
            </div>
        </div>
    </div>
