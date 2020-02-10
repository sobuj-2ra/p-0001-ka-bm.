@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Production Manager
@endsection

<!--Page Header-->
@section('page-header')
    Production Status
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
                            <h3 class="text-center">RUNNING PRODUCTION</h3>
                            <?php foreach ($machine_datas as $machine_data_single) {
                            if (isset($machine_data_single->machine->machine_name) && !empty($machine_data_single->machine->machine_name)){
                            ?>
                            <form action="{{route('/update-production-status' )}}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="unique_id" value="{{$machine_data_single->machine->unique_id}}">
                                <input type="hidden" name="ref_no" value="{{$machine_data_single->machine->order_ref_no}}">
                            <div class="bg-primary">
                                <h1 style="padding: 10px 3px">
                                    <?php echo $machine_data_single->machine->unique_id . ' - ' . $machine_data_single->machine->machine_name; ?>
                                </h1>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-submit"> Finish </button>
                            </div>
                            </form>
                            <?php } } ?>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
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
                                        ->orderBy('queue_no', 'asc')
                                        ->get();
                                    $count_total = sizeof($order_request_per_machine);

                                    if (isset($order_request_per_machine)){
                                    $machineName = DB::table('tbl_addmachine')
                                        ->where('id', $machine->id)
                                        ->where('status', 1)
                                        ->first();
                                    echo "<tr><td colspan='4' class='text-center'><h4>$machineName->machine_name</h4></td></tr>";
                                    $i=0; foreach ($order_request_per_machine as $oder_list) { $i++; ?>

                                    <tr>
                                        <td scope="col">{{$i}} </td>
                                        <td scope="col"><a href="{{URL::to('/details-order/'.$oder_list->order_ref_no)}}"
                                                           target="_blank">
                                                <button class="btn btn-flat btn-warning btn-xs"
                                                        style="font-size: 17px">{{$oder_list->order_ref_no}}</button>
                                            </a></td>
                                        <td scope="col">{{$oder_list->unique_id}}</td>
                                        {{--<td scope="col">{{$list->weight.' '.$list->unit_name}}</td>--}}
                                        <td scope="col">
                                            <form action="{{route('/production-start' )}}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="order_ref_no"
                                                       value="{{$oder_list->order_ref_no}}">
                                                <input type="hidden" name="unique_id_db"
                                                       value="{{$oder_list->unique_id}}">
                                                <input type="hidden" name="machine_id"
                                                       value="{{$oder_list->machine_id}}">
                                                <div class="form-group">
                                                    <label>{{$machineName->machine_name}} -</label>
                                                    <label> Queue No: {{$oder_list->queue_no}}</label>
                                                </div>
                                                <?php if ($i == 1){ ?>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="unique_id" placeholder="Scan Barcode" autocomplete="off" required="">
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-sm btn-success btn-submit">Start</button>
                                                </div>
                                                <?php } ?>

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
                    <br>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        setTimeout(function() {
            location.reload();
        }, 120000);

    </script>

@endsection


