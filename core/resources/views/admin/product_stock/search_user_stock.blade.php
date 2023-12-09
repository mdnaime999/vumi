<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
                    <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                        <thead>
                            <tr>
                                <th>ক্রমিক</th>
                                <th>নাম</th>
                                <th>স্টক তথ্য</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        নামঃ <span class="text-bold">{{ $user->name }}</span> <br>
                                        পদবীঃ <span class="text-bold">{{ $user->roles->designations->name ?? "" }}</span> <br>
                                        বিভাগঃ <span class="text-bold">{{ $user->roles->departments->name ?? "" }}</span>
                                    </td>
                                    <td>
                                    <?php
                                        $i = 1;
                                        foreach ($user->requisitions as $key => $requisition) {
                                            $check = App\Models\RequisitionDetails::where('requisition_id', $requisition->id)->get();
                                            foreach ($check as $key => $value) {
                                                $k = $i++;
                                                $date = \Carbon\Carbon::parse($value->updated_at)->format('d-m-Y');
                                                echo ' ' . en_to_bn($k) . '. ' . $value->products->name . ' - ' . en_to_bn($value->product_need) . ' (' . en_to_bn($date).')'.'</br>';
                                            };
                                        }
                                    ?>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
