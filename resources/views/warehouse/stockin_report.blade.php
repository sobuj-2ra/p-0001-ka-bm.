@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Stock In Report
@endsection

<!--Page Header-->
@section('page-header')
    Stock In Report
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
                                    <form action="{{ URL::to('/stockin-report') }}" method="post">
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
                                    <h4 class="" style="margin: 0px;color: #292929eb;"></h4>
                                    <hr>
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
                                    <button type="submit" class="btn btn-primary pull-right" style="padding: 7px 22px;margin:10px" onclick="printDiv('printableArea')" style="margin-right:10px;">Print</button>
                                    <div id="printableArea">
                                        <style type="text/css" media="print">
                                            @page { size: portrait;font-size: 14px;
                                            }
                                        </style>
                                        <div class="col-xs-12">
                                            <h1 class="custom-font" style="text-align: center;font-family: bestmixFont;">BESTMIX (BD) LIMITED</h1>
                                            <h4 style="text-align: center"><i>Vill: Pakutia, Post: D-Pakutia,<br> P.S: Ghatail, Dist: Tangail</i></h4>
                                            <br>
                                            <h4 style="text-align:center"><b>Stock In Details</b></h4>
                                        </div>
                                    <table width="100%" id="showproduct" class="table-bordered table"
                                           style="font-size:14px;">
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Weight</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $n=0; @endphp
                                        @foreach($todayStockIns as $todayStockIn)
                                            @php $n++; @endphp
                                            <tr>
                                                <td scope="col">{{$n}}</td>
                                                <td scope="col">
                                                        <button class="btn btn-flat btn-warning btn-xs" style="font-size: 17px">{{@$todayStockIn->product_name}}</button>

                                                </td>
                                                <td scope="col">{{$todayStockIn->total_product_qty}}</td>
                                                <td scope="col">{{$todayStockIn->total_product_weight}}</td>
                                                <td scope="col">{{$todayStockIn->created_at}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!-- /.table-responsive -->
                                    </div>
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