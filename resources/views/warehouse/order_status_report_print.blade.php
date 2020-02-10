@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Order Request Report
@endsection

<!--Page Header-->
@section('page-header')
    Order Report <?php echo $status; ?>
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">
                    <!-- Code Here.... -->
                    <div class="row" id="printDiv">
                        <style type="text/css" media="print">
                            /*@page { size: portrait;}*/
                            @media print
                            {
                                #showPrint
                                {
                                    display: block;
                                    overflow: visible;
                                }
                            }

                        </style>
                        <div class="col-md-12">
                            <div class="row no-print">
                                <div class="col-xs-12">
                                    <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;" onclick="printDiv('printDiv')">
                                        <i class="fa fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                            <div class="table_view" style="padding: 10px">
                                <div class="panel-body">
                                    <div class="col-xs-12">
                                        <h1 class="custom-font" style="text-align: center;font-family: bestmixFont;">BESTMIX (BD) LIMITED</h1>
                                        <h4 style="text-align: center"><i>Vill: Pakutia, Post: D-Pakutia,<br> P.S: Ghatail, Dist: Tangail</i></h4>
                                        <br>
                                        <h4 style="text-align:center"><b>Order Request Status</b></h4>
                                    </div>
                                    <table width="100%" id="" class="table-bordered table"
                                           style="font-size:14px;">
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Order Ref No</th>
                                            <th scope="col">Request Date</th>
                                            <th scope="col">Customer Name</th>
                                            <th scope="col">Troli Details</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $n=0; @endphp
                                        @foreach($show_product as $get_product)
                                            @php $n++; @endphp
                                            <?php if (isset($get_product->unique_number[0]) && !empty($get_product->unique_number[0])) { ?>
                                            <tr>
                                                <td scope="col">{{$n}}</td>
                                                <td scope="col">
                                                    <a class="no-print" href="{{URL::to('/details-order/'.$get_product->order_ref_no)}}"
                                                       target="_blank">
                                                        <button class="btn btn-flat btn-warning btn-xs"
                                                                style="font-size: 17px">{{$get_product->order_ref_no}}</button>
                                                    </a>
                                                    <span class="hidden" id="showPrint">{{$get_product->order_ref_no}}</span>
                                                </td>
                                                <td scope="col">{{$get_product->request_date}}</td>
                                                <td scope="col">{{$get_product->company_name}}</td>
                                                <td scope="col">
                                                    <table class="table-bordered table">
                                                        <?php foreach ($get_product->unique_number as $item) { ?>
                                                            <tr style="">
                                                                <td>{{$item->unique_id}}</td>
                                                                <td>
                                                                    <?php if ($status == 'Finish'){
                                                                        echo '<button class="btn btn-flat btn-success btn-xs">'.$item->status.'</button>';
                                                                    }elseif ($status == 'Running'){
                                                                        echo '<button class="btn btn-flat btn-warning btn-xs">'.$item->status.'</button>';
                                                                    }elseif ($status == 'Ready'){
                                                                        echo '<button class="btn btn-flat btn-info btn-xs">'.$status.'</button>';
                                                                    }elseif ($status == 'Pending'){
                                                                        echo '<button class="btn btn-flat btn-danger btn-xs">'.$status.'</button>';
                                                                    }elseif ($status ==  'All'){
                                                                        if ($item->status == 'Active'){
                                                                            $name= 'Ready';
                                                                            $color = 'btn-info';
                                                                        }elseif ($item->status == NULL){
                                                                            $name= 'Pending';
                                                                            $color = 'btn-danger';
                                                                        }elseif ($item->status == 'Running'){
                                                                            $name= 'Running';
                                                                            $color = 'btn-warning';
                                                                        }elseif ($item->status == 'Finish'){
                                                                            $name= 'Finish';
                                                                            $color = 'btn-success';
                                                                        }
                                                                        echo '<button style="width:60px" class="btn btn-flat '.$color.' btn-xs">'.$name.'</button>';
                                                                    } ?>
                                                                </td>
                                                            </tr>
                                                     <?php  }
                                                     ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php } ?>
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
    <script type="text/javascript">
        document.getElementById("showPrint").addClass('hidden');
        function printDiv(printDiv) {
            var printContents = document.getElementById(printDiv).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            //$('#showPrint').removeClass('hidden');
            window.print();

            document.body.innerHTML = originalContents;
        }
        {{--$(window).on('afterprint', function () {--}}
            {{--window.location.href="{{ url("/details-order/$refer_id") }}";--}}
        {{--});--}}

    </script>
@endsection
