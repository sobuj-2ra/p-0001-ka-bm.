@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Show Customer
@endsection

<!--Page Header-->
@section('page-header')
  View Customer (<a href="{{URL::to('/customer')}}">Add Customer</a>)
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
                                            <h4 style="text-align:center"><b>All Customer List</b></h4>
                                        </div>
                                        <table width="100%" id="showcustomer" class="table-bordered table" style="font-size:14px;">
                                            <thead>
                                            <tr>
                                                <th scope="col">SL</th>
                                                <th scope="col">Customer ID</th>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Contact Person Name (Head)</th>
                                                <th scope="col">Phone Number(Head)</th>
                                                <th scope="col">Contact Person Name (Factory)</th>
                                                <th scope="col">Phone Number(Factory)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @php $n=0; @endphp
                                                @foreach($showcustomer as $get_customer)
                                                @php $n++; @endphp
                                                <tr>
                                                <td scope="col">{{$n}}</td>
                                                <td scope="col">{{$get_customer->company_id}}</td>
                                                <td scope="col">{{$get_customer->company_name}}</td>
                                                <td scope="col">{{$get_customer->head_contact_name}}</td>
                                                <td scope="col">{{$get_customer->head_phone_number}}</td>
                                                <td scope="col">{{$get_customer->factory_contact_person_name}}</td>
                                                <td scope="col">{{$get_customer->factory_phone_number}}</td>


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