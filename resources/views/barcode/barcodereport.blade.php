@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Details Barcode
@endsection

<!--Page Header-->
@section('page-header')
Show All Barcode Print List
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
                                            <h4 style="text-align:center"><b>Barcode Print List</b></h4>
                                        </div>
                                    <table width="100%" id="showproduct" class="table-bordered table" style="font-size:14px;">
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Generate BarCode</th>
                                            <th scope="col">Generate Date</th>
                                            <th scope="col">Total Print</th>
                                            <th scope="col" class="hidden-print">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $n=0; @endphp
                                            @foreach($showprintdata as $get_product)
                                            @php $n++; @endphp
                                            <tr>
                                            <td scope="col">{{$n}}</td>
                                            <td scope="col">{{$get_product->product_name}}</td>
                                            <td scope="col">{{$get_product->product_qty}}</td>                                         
                                            <td scope="col">{{$get_product->created_at}}</td>                                         
                                            <td scope="col">{{$get_product->status}}</td>                                         
                                            <td scope="col" class="hidden-print">
                                            <a class="hidden-print" onclick="return confirm('Are you sure want to Re-Print this?');" href=""><button class="btn btn-warning hidden-print">Re-Print </button></a>
                                            </td>                                         
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