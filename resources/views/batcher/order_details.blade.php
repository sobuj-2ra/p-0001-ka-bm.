@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Production Manager
@endsection

<!--Page Header-->
@section('page-header')
    Order Details- ID: {{$refer_id}}
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <section class="invoice" id="printDiv">
        <style type="text/css" media="print">
            @page { size: portrait;

            }
        </style>
        <div class="row">
            <div class="col-xs-12">

                <span class="page-header">
                    <h1 class="custom-font" style="text-align: center;font-family: bestmixFont;">BESTMIX (BD) LIMITED</h1>
                    <h4 style="text-align: center"><i>Vill: Pakutia, Post: D-Pakutia,<br> P.S: Ghatail, Dist: Tangail</i></h4>
                    <br>
                    <h4 style="text-align:center"><b>Order Request Details</b></h4>
                    <small class="pull-right">
                        Date: <?php echo date('d/m/Y', strtotime($pro_customer->request_date)); ?></small>
                </span>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>{{$pro_customer->company_name}}</strong><br>
                    {{$pro_customer->head_address}}<br>
                    {{$pro_customer->head_contact_name}}<br>
                    {{$pro_customer->head_phone_number}}<br>
                    Email: {{$pro_customer->head_email}}
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Factory Details</strong><br>
                    {{$pro_customer->factory_address}}<br>
                    {{$pro_customer->factory_contact_person_name}}<br>
                    {{$pro_customer->factory_land_phone_number}}<br>
                    {{$pro_customer->factory_phone_number}}<br>
                    Email: {{$pro_customer->factory_email}}
                </address>
            </div>
            <div class="col-sm-4 invoice-col">

            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <h4>Order Id: {{$refer_id}}</h4>
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Product Name</th>
                        <th>Weight</th>
                        <th>Unit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=0; foreach ($pro_details as $pro_detail) { $i++; ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$pro_detail->product_name}}</td>
                        <td>{{$pro_detail->product_weight}}</td>
                        <td>{{$pro_detail->unit_name}}</td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-7">

            </div>
            <!-- /.col -->
            <div class="col-xs-5">
                <p class="lead"></p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th style="width:40%">Total Weight:</th>
                            <td style="text-align: center;font-weight: 700">{{$total_weight}} Gram</td>
                        </tr>
                        <tr>
                            <th style="width:40%"></th>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row no-print">
            <div class="col-xs-12">
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;" onclick="printDiv('printDiv')">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        function printDiv(printDiv) {
            var printContents = document.getElementById(printDiv).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
        $(window).on('afterprint', function () {
            window.location.href="{{ url("/details-order/$refer_id") }}";
        });

    </script>


@endsection


