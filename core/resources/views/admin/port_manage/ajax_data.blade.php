
<table id="list" class="table table-bordered" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th style="width: 5%">ক্রমিক</th>
            <th style="width: 15%;">বন্দরের নাম</th>
            <th style="text-align: center;">এল.এ কেস নং</th>
            {{-- <th style="text-align: center; width:10%;">স্থাপনা</th> --}}
            <th style="text-align: center"> দখল গ্রহণ / হস্তান্তর</th>
            <th style="text-align: center">গেজেট প্রকাশের তারিখ </th>
            <th style="text-align: center">নামজারী কেস নং </th>
            <th style="text-align: center; width: 13%;">জমির পরিমান (একরে )</th>
            <th style="text-align: center">মোট জমির পরিমান (একরে)</th>
        </tr>
    </thead>
    <tbody>

            <?php $totalLand = 0; ?>
            @foreach ($ports as $sl => $port_item)
                @forelse ($port_item->ls_case_no as $key => $ls_item)
                    @if ($key > 0)
                        <tr>
                            <td style="text-align: center">
                                <a class="hoverContent" type="button" style="color:black;"
                                    href="{{ route('tofsil.list', ['id' => $ls_item->id]) }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Tooltip on top">{{ $ls_item->number ? $ls_item->number : '' }}</a>
                            </td>
                            {{-- <td>
                            <?php
                            $buildings = DB::table('establishments')
                                ->where('l_s_case_id', $ls_item->id)
                                ->get();
                            ?>
                            <ol style="padding-left: .7rem; margin-bottom:0">
                                @if ($buildings)
                                    @foreach ($buildings as $building)
                                        <a class="hoverContent" href="{{ route('building.details', ['id' => $building->id]) }}" style="color:black;"><li>{{ $building->name }}</li></a>
                                    @endforeach
                                @endif
                            </ol>
                        </td> --}}
                            <td style="text-align: center">
                                {{ $ls_item->possession_date ? en_to_bn(\Carbon\Carbon::parse($ls_item->possession_date)->format('d/m/Y')) : '' }}
                            </td>
                            <td style="text-align: center">
                                {{ $ls_item->gazette_date ? en_to_bn(\Carbon\Carbon::parse($ls_item->gazette_date)->format('d/m/Y')) : '' }}
                            </td>
                            <td style="text-align: center;"><a style="color:black;" class="hoverContent"
                                    href="{{ asset($ls_item->pdf) }}"
                                    target="__blank">{{ $ls_item->namjari_case_id ? $ls_item->namjari_case_id : '' }}</a>
                            </td>
                            <td style="text-align: center">
                                {{ $ls_item->total_land ? en_to_bn($ls_item->total_land) : '' }}
                                <?php $totalLand += $ls_item->total_land; ?>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td rowspan="{{ count($port_item->ls_case_no) }}">{{ en_to_bn($sl + 1) }}.
                            </td>
                            <td rowspan="{{ count($port_item->ls_case_no) }}">{{ $port_item->port_name }}
                            </td>
                            <td style="text-align: center"><a class="hoverContent" style="color:black;"
                                    href="{{ route('tofsil.list', ['id' => $ls_item->id]) }}">{{ $ls_item->number ? $ls_item->number : '' }}</a>
                            </td>
                            {{-- <td>
                            <?php
                            $buildings = DB::table('establishments')
                                ->where('l_s_case_id', $ls_item->id)
                                ->get();
                            ?>
                            <ol style="padding-left: .7rem; margin-bottom:0">
                                @if ($buildings)
                                    @foreach ($buildings as $building)
                                    <a class="hoverContent" href="{{ route('building.details', ['id' => $building->id]) }}" style="color:black;"><li>{{ $building->name }}</li></a>
                                    @endforeach
                                @endif
                            </ol>
                        </td> --}}
                            <td style="text-align: center">
                                {{ $ls_item->possession_date ? en_to_bn(\Carbon\Carbon::parse($ls_item->possession_date)->format('d/m/Y')) : '' }}
                            </td>
                            <td style="text-align: center">
                                {{ $ls_item->gazette_date ? en_to_bn(\Carbon\Carbon::parse($ls_item->gazette_date)->format('d/m/Y')) : '' }}
                            </td>
                            <td style="text-align: center;"><a style="color:black;" class="hoverContent"
                                    href="{{ asset($ls_item->pdf) }}" target="__blank">
                                    {{ $ls_item->namjari_case_id ? $ls_item->namjari_case_id : '' }}</a>
                            </td>
                            <td style="text-align: center">
                                {{ $ls_item->total_land ? en_to_bn($ls_item->total_land) : '' }}</td>
                            <td style="text-align: center" rowspan="{{ count($port_item->ls_case_no) }}">
                                {{ $port_item->ls_case_no ? en_to_bn((float) $port_item->ls_case_no->sum('total_land')) : '' }}
                                <?php $totalLand += $ls_item->total_land; ?>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td rowspan="">{{ en_to_bn($sl + 1) }}.</td>
                        <td rowspan="">{{ $port_item->port_name ? $port_item->port_name : '' }}</td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                    </tr>
                @endforelse
            @endforeach
            <tr>
                <td colspan="8" style="text-align: right;">
                    <p
                        style="
                margin-right: 8px;
            ">
                        মোট জমির পরিমানঃ {{ en_to_bn($totalLand) }} </p>
                </td>
            </tr>

    </tbody>
</table>
