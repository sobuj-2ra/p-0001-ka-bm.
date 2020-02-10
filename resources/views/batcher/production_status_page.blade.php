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
                    @if(Session::has('message'))
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4 alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                </button>
                                <h4> {{ Session::get('message') }}</h4>
                            </div>
                        </div>
                    @endif
                    <div class="row">

                        <form action="{{route('/search-machine-queue' )}}" method="POST">
                            {{ csrf_field() }}
                            <div class="col-md-3 col-md-offset-1" style="padding: 20px">
                                <div class="form-group">
                                    <select name="machine_id" class="form-control select2" required
                                            style="width: 100%;padding: 6px 0px;">
                                        <option value="">Select Machine</option>
                                        <?php foreach ($machines as $machine){
                                        ?>
                                        <option value="{{$machine->id}}" <?php if ($id == $machine->id) {
                                            echo 'selected';
                                        } ?>>{{$machine->machine_name}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group" style="padding: 20px 0px 0px 0px">
                                    <button type="submit" class="btn btn-success btn-submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row" style="min-height: 400px">
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="text-center" style="padding:1px 0; margin:0;">Chember One</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table_view" style="padding: 10px;font-size: 17px">
                                        <?php if (isset($name) && !empty($name)){  ?>
                                        <div>
                                            <?php if (isset($running) && !empty($running)){ ?>
                                                <form action="{{route('/update-production-status' )}}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="unique_id" value="{{$running->unique_id}}">
                                                    <input type="hidden" name="ref_no" value="{{$running->order_ref_no}}">
                                                    <input type="hidden" name="machine_id" value="{{$running->machine_id}}">
                                                    <div class="bg-primary">
                                                        <h1 style="padding: 10px 3px">
                                                            <?php echo $running->unique_id; ?>
                                                        </h1>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-success btn-submit"> Shift Chember </button>
                                                    </div>
                                                </form>
                                            <?php }else{ ?>
                                            <form action="{{route('/production-start' )}}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="machine_id"
                                                       value="{{$name->id}}">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="unique_id"
                                                           placeholder="Scan Barcode" autocomplete="off" required="">
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-sm btn-success btn-submit">Start</button>
                                                </div>
                                            </form>
                                            <?php } ?>

                                        </div>
                                        <table width="100%" id="addproductpage_old" class="table-bordered table"
                                               style="font-size:17px;">

                                            <tbody>
                                            <tr>
                                                <td colspan='4' class='text-center'><h3
                                                            style="font-weight: bold"><?php echo $name->machine_name; ?></h3>
                                                </td>
                                            </tr>
                                            <th style="font-weight: 400;background: #e1e8d985">Order Ref. No</th>
                                            <th style="font-weight: 400;background: #e1e8d985">Unique ID</th>
                                            <th style="font-weight: 400;background: #e1e8d985">Queue No</th>
                                            <?php if (isset($queue_lists) && !empty($queue_lists)){  $i = 0;  foreach ($queue_lists as $machine) {  $i++; ?>
                                            <tr>
                                                <td scope="col">{{$machine->order_ref_no}}</td>
                                                <td scope="col">{{$machine->unique_id}}</td>
                                                <td scope="col">{{$machine->queue_no}}</td>
                                            </tr>
                                            <?php
                                            } } ?>
                                            </tbody>
                                        </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="text-center"  style="padding:1px 0; margin:0;">Chember Two</h3>
                                </div>
                                <div class="panel-body">
                                     <div class="table_view" style="padding: 10px;font-size: 17px">
                                        <?php if (isset($name) && !empty($name)){  ?>
                                        <div>
                                            <?php if (isset($running2) && !empty($running2)){ ?>
                                                <form action="{{route('/finish-production-status' )}}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="unique_id" value="{{$running2->unique_id}}">
                                                    <input type="hidden" name="ref_no" value="{{$running2->order_ref_no}}">
                                                    <input type="hidden" name="machine_id" value="{{$running2->machine_id}}">
                                                    <input type="hidden" name="finish_id" value="0">
                                                    <div class="bg-primary">
                                                        <h1 style="padding: 10px 3px">
                                                            <?php echo $running2->unique_id; ?>
                                                        </h1>
                                                    </div>
                                                </form>
                                            <?php }else{ ?>
                                                <h2 class="text-center" style="color:#444;">Chember Two is Empty</h2>
                                            <?php } ?>

                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{--past--}}


                    <br>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        setTimeout(function () {
            location.reload();
        }, 120000);

    </script>

@endsection


