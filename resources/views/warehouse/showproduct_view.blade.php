@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Details Product
@endsection

<!--Page Header-->
@section('page-header')
Show Product
@endsection

<!--Page Content Start Here-->
@section('page-content')
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
                                            <h4 style="text-align:center"><b>PRODUCT({{$proType->product_type}}) STORE DETAILS</b></h4>
                                        </div>
                                    <table width="100%" id="showproduct" class="table-bordered table table-striped" style="font-size:14px;">
                                        <thead>
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Product Code</th>
                                            <th scope="col">Bag Qty</th>
                                            <th scope="col">Weight(kg)</th>
                                            <th scope="col">WIP(kg)</th>
                                            <th scope="col">Total Weight(kg)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $n=0; $total_qty = 0; $total_weight= 0; $total_wip = 0;$total_net = 0;@endphp
                                            @foreach($show_product as $get_product)
                                            @php
                                             $n++;
                                             $total_qty += $get_product->total_bag;
                                             $total_weight += $get_product->total_weight;
                                             $total_wip += $get_product->wip;
                                             $net_weight = 0;
                                             $net_weight = $get_product->total_weight + $get_product->wip;
                                             $total_net += $net_weight;
                                            @endphp
                                            <tr>
                                            <td scope="col">{{$n}}</td>
                                            <td scope="col">{{$get_product->product_name}}</td>
                                            <td scope="col">{{$get_product->product_code}}</td>
                                            <td scope="col">{{$get_product->total_bag}}</td>
                                            <td scope="col">{{$get_product->total_weight}}</td>
                                            <td scope="col">{{$get_product->wip}}</td>
                                            <td scope="col">{{$net_weight}}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                              <td colspan="3" class="text-center"><b>Total</b></td>
                                              <td><b>{{$total_qty}}</b></td>
                                              <td><b>{{$total_weight}}</b></td>
                                              <td><b>{{$total_wip}}</b></td>
                                              <td><b>{{$total_net}}</b></td>
                                            </tr>
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
