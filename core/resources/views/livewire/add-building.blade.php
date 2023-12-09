<div>
    <div class="grid-auto  mb-6 " wire:click="@if ($checkPort == 1) resetPort @endif">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="l_s_case_id">বন্দর নাম<span class="text-danger">*</span></label>
                        {{-- <select id="l_s_case_id" class="form-control select2bs4" name="l_s_case_id" value="">
                        <option selected disabled>এল এ কেস নির্বাচন করুন</option>
                        @foreach ($lsCases as $lsCase)
                            <option value="{{ $lsCase->id }}" @if (optional($establishment)->l_s_case_id == $lsCase->id) selected @endif>
                                {{ __($lsCase->number) }}</option>
                        @endforeach
                    </select> --}}
                        <input type="text" name="itemInputsport_name"
                            class="form-control @error('port_name') is-invalid @enderror" list="browsers"
                            wire:model='port_name' placeholder="বন্দর খুজুন" autocomplete="off"
                            wire:click='portNameInput' wire:keydown.escape='resetPort' wire:keydown.tab='resetPoret'
                            wire:keydown.Arrow-Up="decrementHighlightCountry"
                            wire:keydown.Arrow-Down="incrementHighlightCountry" wire:keydown.enter="portEnter" />
                        @error('port_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @if ($checkPort == 1)
                            <div class="card toContact"
                                style="width: 98%; display: flex; flex-basis: auto; flex-direction: column;  flex-grow: 1;  overflow: hidden; position: absolute; z-index: 99999;">
                                @if (count($portData) > 0)
                                    @foreach ($portData as $i => $item)
                                        <a class="list-group-item" wire:click='searchPort({{ $item->id }})'
                                            style="cursor: pointer;" onmouseover='this.style.textDecoration="underline"'
                                            onmouseout='this.style.textDecoration="none"'>{{ $item->port_name }}</a>
                                    @endforeach
                                @else
                                    <div class="list-group-item">No Result</div>
                                @endif
                                <a href="#" class="card-link text-center p-2" wire:click='newPort'>+ নতুন বন্দর
                                    যোগ করুন</a>
                            </div>
                        @endif
                        @if ($newPort == 1)
                            <div class="card toContact"
                                style="width: 98%; display: flex; flex-basis: auto; flex-direction: column;  flex-grow: 1;  overflow: hidden; position: absolute; z-index: 99999;"
                                aria-hidden="true">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="first_name">বন্দর নাম<span
                                                    class='required-star'>*</span></label>
                                            <input type="text" autocomplete="off"
                                                class="form-control mb-2 @error('port_name') is-invalid @enderror"
                                                placeholder="বন্দর নাম" wire:model='port_name' />
                                            @error('port_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="first_name">জেলা<span class='required-star'>*</span></label>
                                            <input type="text" autocomplete="off"
                                                class="form-control @error('district') is-invalid @enderror"
                                                placeholder="জেলা" wire:model='district' />
                                            @error('district')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="upzilla">উপজেলা<span class='required-star'>*</span></label>
                                            <input type="text" autocomplete="off"
                                                class="form-control @error('upzilla') is-invalid @enderror"
                                                placeholder="উপজেলা" wire:model='upzilla' />
                                            @error('upzilla')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="f-right" style="margin-top: 5px">
                                        <button class="btn btn-sm btn-danger" wire:click='newPortCencel'>Cencel</button>
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            wire:click='portSave'>Save</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @foreach ($buildingItems as $key => $buildingItem)
                    <fieldset class="border mb-3 border-3 p-3">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="name{{ $key }}">স্থাপনা নাম<span
                                            class='required-star'>*</span></label>
                                    {{-- <input id="name{{ $key }}" type="text"
                                        wire:model.lazy='buildingItems.{{ $key }}.building_name'
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        name="name" value="" placeholder="স্থাপনের নাম লিখুন" autofocus> --}}
                                    <select wire:model.lazy='buildingItems.{{ $key }}.building_id' class="form-control">
                                        <option disabled>একটি সিলেক্ট করুণ</option>
                                        @foreach ($infrastures as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group text-center">
                                    {{-- <label for="name">@if ($key < 1)নতুন স্থাপনা @else স্থাপনা মছুন @endif</label> --}}
                                    <label for="name" style="color: white;">.</label>
                                    @if ($key < 1)
                                        <button wire:click='addNewBuildingItem()'
                                            class="form-control btn btn-sm btn-primary text-center justify-content-between">+</button>
                                    @else
                                        <button style="color: white;" class="form-control btn btn-danger"
                                            wire:click='removeBuilding({{ $key }})'>x</button>
                                    @endif
                                </div>
                            </div>
                            @foreach ($buildingItem['detailItems'] as $sl => $item)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="floor_num{{ $key }}{{ $sl }}">বিবরণী</label>
                                        <input id="floor_num{{ $key }}{{ $sl }}"
                                            wire:model='buildingItems.{{ $key }}.detailItems.{{ $sl }}.details'
                                            type="text"
                                            class="form-control{{ $errors->has('floor_num') ? ' is-invalid' : '' }}"
                                            name="floor_num"
                                            value="{{ old('floor_num', optional($establishment)->floor_num) }}"
                                            placeholder="বিবরণী লিখুন" @if($sl < 6) disabled @endif autofocus>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="room_num{{ $key }}{{ $sl }}">সংখ্যা</label>
                                        <input id="room_num{{ $key }}{{ $sl }}"
                                            wire:model='buildingItems.{{ $key }}.detailItems.{{ $sl }}.number'
                                            type="text"
                                            class="form-control{{ $errors->has('room_num') ? ' is-invalid' : '' }}"
                                            name="room_num"
                                            value="{{ old('room_num', optional($establishment)->room_num) }}"
                                            placeholder="{{  $item['details'] }} লিখুন" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group text-center">
                                        {{-- <label for="">@if ($sl < 1)নতুন বিবরণী @else বিবরণী মছুন @endif</label> --}}
                                        @if ($sl == 5)
                                            <label for="name">নতুন</label>
                                            <button style="color: white;" class="form-control btn btn-primary"
                                                wire:click='addNewDetails({{ $key }})'>+</button>
                                        @elseif($sl >= 5)
                                            <label for="name" style="color: white;">.</label>
                                            <button style="color: white;" class="form-control btn btn-danger"
                                                wire:click='removeDetails({{ $key }}, {{ $sl }})'>x</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                @endforeach

                {{-- <div class="col-md-6"> --}}
                {{-- {{status}} --}}
                {{-- <div class="form-group">
                    <label for="status"> স্ট্যাটাস <span class='required-star'>*</span></label>
                    <select id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" autofocus>
                        <option value="" selected disabled>স্ট্যাটাস নির্বাচন করুন</option>
                        <option value="1" @if (optional($establishment)->status == '1')
                            selected
                            @endif selected>সক্রিয়</option>
                        <option value="0" @if (optional($establishment)->status == '0')
                            selected
                            @endif>নিষ্ক্রিয়</option>
                    </select>

                </div> --}}
                {{-- </div> --}}
            </div>
            <div class="card-footer">
                <a href="{{ route('manage.establishment') }}">
                    <button type="button" class="btn btn-danger">বাতিল </button>
                </a>
                <button onclick="typeSubmit()" wire:click='buildingsSubmit()' type="submit" class="btn btn-info float-right">সেভ করুন</button>
            </div>
        </div>
    </div>
</div>
