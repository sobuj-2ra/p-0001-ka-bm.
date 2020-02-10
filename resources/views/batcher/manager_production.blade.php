@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Production Manager
@endsection

<!--Page Header-->
@section('page-header')
    Production List
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">
                    <div class="row">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                            <h3 class="text-center bg-info">RUNNING PRODUCTION</h3>
                            <?php foreach ($machine_datas as $machine_data_single) {
                            if (isset($machine_data_single->machine->machine_name) && !empty($machine_data_single->machine->machine_name)){
                            ?>

                                <input type="hidden" name="unique_id" value="{{$machine_data_single->machine->unique_id}}">
                                <input type="hidden" name="ref_no" value="{{$machine_data_single->machine->order_ref_no}}">
                                <div class="bg-primary">
                                    <h1 style="padding: 10px 3px">
                                        <?php echo $machine_data_single->machine->unique_id . ' - ' . $machine_data_single->machine->machine_name; ?>
                                    </h1>
                                </div>
                            <?php } } ?>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div>
                                <div class="table_view" style="padding: 10px">
                                    <table width="100%" id="addproductpage_old" class="table-bordered table"
                                           style="font-size:14px;">
                                        <h3>Production Queue List</h3>
                                        <thead style="background:#ddd">
                                        <tr>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count_order=0;  foreach ($machines as $machine) {  ?>
                                            <?php
                                        $order_request_per_machine = DB::table('tbl_queue_list')
                                            ->where('machine_id', $machine->id)
                                            ->where('status', 1)
                                            ->get();
                                        $count_total = sizeof($order_request_per_machine);

                                        if (isset($order_request_per_machine)){
                                        $machineName = DB::table('tbl_addmachine')
                                            ->where('id', $machine->id)
                                            ->where('status', 1)
                                            ->first();
                                        echo "<tr><td colspan='3' class='text-center'><h4>$machineName->machine_name</h4></td></tr>";
                                        $i=0; foreach ($order_request_per_machine as $oder_list) { $i++;  ?>

                                        <tr>
                                            <td scope="col">{{$i}} </td>
                                            <td scope="col"><a href="{{URL::to('/details-order/'.$oder_list->order_ref_no)}}"
                                                               target="_blank">
                                                    <button class="btn btn-flat btn-warning btn-xs"
                                                            style="font-size: 17px">{{$oder_list->order_ref_no}}</button>
                                                </a></td>
                                            {{--<td scope="col">{{$list->company_name}}</td>--}}
                                            {{--<td scope="col">{{$list->weight.' '.$list->unit_name}}</td>--}}
                                            <td scope="col">
                                                <form action="{{route('/update-production-list' )}}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="order_ref_no"
                                                           value="{{$oder_list->order_ref_no}}">
                                                    <input type="hidden" name="unique_id"
                                                           value="{{$oder_list->unique_id}}">
                                                    <div class="form-group">
                                                        <select name="machine_id" class="form-control select2" required
                                                                style="width: 100%;padding: 6px 0px;">
                                                            <option value="">Machine</option>
                                                            <?php foreach ($machines as $machine){
                                                            $refer_no = DB::table('tbl_queue_list')
                                                                ->where('unique_id', $oder_list->unique_id)
                                                                ->first();
                                                            ?>
                                                            <option value="{{$machine->id}}" <?php if ($machine->id == $refer_no->machine_id) {
                                                                echo 'selected';
                                                            } ?>>{{$machine->machine_name}}</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select name="queue_id" class="form-control select2" required
                                                                style="width: 100%;padding: 6px 0px;">
                                                            <option value="">Queue</option>
                                                            <?php
                                                            $ref_queue = DB::table('tbl_queue_list')
                                                                ->where('unique_id', $oder_list->unique_id)
                                                                ->first();
                                                            for($j = 1; $j < $count_total + 2; $j++){
                                                            ?>
                                                            <option value="{{$j}}" <?php if ($j == $ref_queue->queue_no) {
                                                                echo 'selected';
                                                            } ?>><?php echo $j; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-success btn-submit">Update</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php  }
                                         }
                                        $count_order +=$count_total;
                                        } ?>
                                        </tbody></table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="table_view" style="padding: 10px">
                                <table width="100%" id="addproductpage_old" class="table-bordered table"
                                       style="font-size:14px;">
                                    <h3>Production Pending List</h3>
                                    <thead style="background:#ddd">
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Order Referrer ID</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Total Weight</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 0; foreach ($lists as $list){ $i++; ?>
                                    <tr>
                                        <td scope="col">{{$i}}</td>
                                        <td scope="col"><a href="{{URL::to('/details-order/'.$list->order_ref_no)}}"
                                                           target="_blank">
                                                <button class="btn btn-flat btn-warning btn-xs"
                                                        style="font-size: 17px">{{$list->order_ref_no}}</button>
                                            </a></td>
                                        @php

                                        @endphp
                                        <td scope="col">{{@$list->getRefType->ref_type}}</td>
                                        <td scope="col">{{$list->company_name}}</td>
                                        <td scope="col">{{$list->weight.' '.$list->unit_name}}</td>
                                        <td scope="col">
                                            <form action="{{route('/update-production-list' )}}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="order_ref_no"
                                                       value="{{$list->order_ref_no}}">
                                                <input type="hidden" name="unique_id"
                                                       value="{{$list->unique_id}}">
                                                <div class="form-group">
                                                    <select name="machine_id" class="form-control select2" required
                                                            style="width: 100%;padding: 6px 0px;">
                                                        <option value="">Machine</option>
                                                        <?php foreach ($machines as $machine){
                                                        ?>
                                                        <option value="{{$machine->id}}">{{$machine->machine_name}}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select name="queue_id" class="form-control select2" required
                                                            style="width: 100%;padding: 6px 0px;">
                                                        <option value="">Queue</option>
                                                        <?php
                                                        for($j = 1; $j <= $count_order + 1; $j++){
                                                        ?>
                                                        <option value="{{$j}}"><?php echo $j; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-success btn-submit">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        setTimeout(function () {
            location.reload();
        }, 300000);

    </script>


@endsection


