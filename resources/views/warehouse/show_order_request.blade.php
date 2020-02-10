@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Order Request Report
@endsection

<!--Page Header-->
@section('page-header')
    Order Request Report
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-5">
                            <div style="margin: 10px; border: 2px solid #dddddd52; border-radius: 5px">
                                <div style="border-top: 5px solid #bd4747; padding: 5px; margin: 5px;">
                                    <h4 class="" style="margin: 0px;color: #292929eb;">Date To Date Search</h4>
                                    <hr>
                                    <form action="{{ URL::to('/order-report-search') }}" method="post" target="_blank">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="form_date"><i>FORM DATE:</i></label>
                                            <input type="text" class="form-control datepicker"
                                                   value="<?php echo date('d-m-Y'); ?>" name="from_date"
                                                   data-date-format="dd/mm/yyyy" required autocomplete="off">
                                            <span id="status_response" style="font-size: 12px;float: right;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="to_date"><i>TO DATE:</i></label>
                                            <input type="text" class="form-control datepicker"
                                                   value="<?php echo date('d-m-Y'); ?>" name="to_date"
                                                   data-date-format="dd/mm/yyyy" required autocomplete="off">
                                        </div>
                                        <hr>
                                        <div class="footer-box">
                                            <button type="reset" class="btn btn-danger">RESET</button>
                                            <button type="submit" id="submit" class="btn btn-info pull-right">SUBMIT
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <div style="margin: 10px; border: 2px solid #dddddd52; border-radius: 5px">
                                <div style="border-top: 5px solid #bd4747; padding: 5px; margin: 5px;">
                                    <h4 class="" style="margin: 0px;color: #292929eb;">Search By Order Ref. No.</h4>
                                    <hr>
                                    <form action="{{ URL::to('/search-by-reference') }}" method="post" target="_blank">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="form_date"><i>Order Ref. No:</i></label>
                                            <select required class="form-control selectpicker" name="order_ref_no"
                                                    style="width: 100%;" data-show-subtext="true"
                                                    data-live-search="true">
                                                <option value="">Select Order</option>
                                                @foreach ($orders as $order)
                                                    <option value="{{ $order->order_ref_no }}"> {{ $order->order_ref_no }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <hr>
                                        <div class="footer-box">
                                            <button type="reset" class="btn btn-danger">RESET</button>
                                            <button type="submit" id="submit" class="btn btn-info pull-right">SUBMIT
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">
                    <!-- Code Here.... -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table_view" style="padding: 10px">
                                <div class="panel-body">
                                    <table width="100%" id="showproduct" class="table-bordered table"
                                           style="font-size:14px;">
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Order Ref No</th>
                                            <th scope="col">Request Date</th>
                                            <th scope="col">Customer Name</th>
                                            <th scope="col">Total Weight</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $n=0; @endphp
                                        @foreach($show_product as $get_product)
                                            @php $n++; @endphp
                                            <tr>
                                                <td scope="col">{{$n}}</td>
                                                <td scope="col">
                                                    <a href="{{URL::to('/details-order/'.$get_product->order_ref_no)}}" target="_blank">
                                                        <button class="btn btn-flat btn-warning btn-xs" style="font-size: 17px">{{$get_product->order_ref_no}}</button>
                                                    </a>
                                                </td>
                                                <td scope="col">{{$get_product->request_date}}</td>
                                                <td scope="col">{{$get_product->company_name}}</td>
                                                <td scope="col">{{$get_product->weight}} Gram</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!-- /.table-responsive -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>
@endsection