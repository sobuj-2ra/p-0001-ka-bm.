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
                    <!-- Code Here.... -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table_view" style="padding: 10px">
                                <div class="panel-body">
                                    <table width="100%" id="showproduct_bySearch" class="table-bordered table"
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