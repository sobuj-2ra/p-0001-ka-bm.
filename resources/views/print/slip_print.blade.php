<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{asset('public/admin/vendor/barcode/js/jquery-3.2.1.slim.min.js')}}"></script>
    <script src="{{asset('public/admin/vendor/barcode/js/JsBarcode.all.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('public/assets/bootstrap/css/bootstrap.min.css')}}" >
    	<link rel="stylesheet" href="{{asset('public/assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style media="screen">

    </style>
  </head>
  <body>


    <section class="invoice" id="printDiv">
        <style type="text/css" media="print">
            @page { size: portrait;
                margin: 0mm 5mm 0mm 5mm;
            }
            @media print {
                .pagebreak { page-break-before: always; } /* page-break-after works, as well */
            }
            .barcode_jk{
                margin-top:-40px;
            }
            table tr td{
              background: red;
            }
        </style>
        <?php $n = 0; ?>
        <?php for($k=1; $k<=$number_of_copy; $k++){  ?>
        <?php $only_barcode = $batch_no?>
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">

                  <img style="padding-top:8px" class="img img-responsive" src="{{asset('public/assets/img/bestmixLogo.jpg')}}" alt="">

                <h5 style="text-align: center"><i>Vill: Pakutia, Post: D-Pakutia,<br> P.S: Ghatail, Dist: Tangail</i></h5>

            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <br>
                <b>Name: </b>{{$query->company_name}}<br>
                <b>Phone: </b>{{$query->head_land_phone_number}}, {{$query->head_phone_number}}<br>

                <h5><strong>Order Id: {{$query->order_ref_no}} <span style="float: right">Batch No: {{$batch_no}}</span></strong></h5></div>
            {{--<div class="col-md-6 " style="width: 50%"></div>--}}
            <div class="col-xs-6">
                <table class="table table-borderless table-condensed">
                    <thead>
                    <tr style="">
                        <th  style="padding:3px">SL</th>
                        <th  style="padding:3px">Product Name</th>
                        <th  style="padding:3px">Weight</th>
                        <th  style="padding:3px">Unit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $j=0;$i=1;
                    $total_weight = 0;
                    $x = 0;
                    for($y = 0;$y < count($products_id);$y++) {
                      if($j < 12){
                        $product_name = DB::table('tbl_addproducts')
                            ->where('id', $products_id[$j])
                            ->first();
                        ?>
                        <tr>
                            <td style="padding:3px;">{{$i}}</td>
                            <td style="padding:3px;">{{$product_name->product_name}}</td>
                            <td style="padding:3px;"><?php $total_weight += $product_weight[$j]; echo $product_weight[$j]; ?></td>
                            <td style="padding:3px;">Gram</td>
                        </tr>

                  <?php
                         $j++;$i++;
                      }
                      else{
                        $x++;
                      }
                    }

                    if($j <= 15){
                        $_x_sum  = 15 - $j;

                        for($_x = 1; $_x <= $_x_sum;$_x++){
                    ?>

                        <tr>
                            <td style="padding:3px;">&nbsp;</td>
                            <td style="padding:3px;"></td>
                            <td style="padding:3px;"></td>
                            <td style="padding:3px;"></td>
                        </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-6">
                <table class="table table-borderless table-condensed">
                    <thead>
                    <tr style="">
                        <th  style="padding:3px">SL</th>
                        <th  style="padding:3px">Product Name</th>
                        <th  style="padding:3px">Weight</th>
                        <th  style="padding:3px">Unit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $jj = 0;
                    for($y = 0;$y < $x ;$y++) {
                    $product_name = DB::table('tbl_addproducts')
                        ->where('id', $products_id[$j])
                        ->first();
                    ?>
                    <tr>
                        <td style="padding:3px">{{$i}}</td>
                        <td style="padding:3px">{{$product_name->product_name}}</td>
                        <td style="padding:3px"><?php $total_weight += $product_weight[$j]; echo $product_weight[$j]; ?></td>
                        <td style="padding:3px">Gram</td>
                    </tr>
                    <?php
                    $jj++;
                     $j++;$i++;
                    }

                    if($jj <= 15){
                        $_x_sum  = 15 - $jj;

                        for($_x = 1; $_x <= $_x_sum;$_x++){
                    ?>

                        <tr>
                            <td style="padding:3px">&nbsp;</td>
                            <td style="padding:3px"></td>
                            <td style="padding:3px"></td>
                            <td style="padding:3px"></td>
                        </tr>
                        <?php

                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-xs-7">
                <p>Production Date: <?php echo date('d M Y') ?></p>
                <p>Expiry Date : <?php echo date('d M Y', strtotime($expiry_date)) ?></p>
            </div>
            <div class="col-xs-5">
                <div class="table-responsive">
                    <table class="table" style="margin-bottom:0px;">
                        <tbody>
                        <tr>
                            <th style=" text-align: right">Total Weight:
                            <span style="font-weight: bold; text-align: center">{{$total_weight}} Gram</span>
                            </th>
                        </tr>
                        <tr style="height:1px;">
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="test" style="">
         <?php
            echo '
            <div class="barcode_jk">
                <div class="barcode_jk_sub">
                    <span>
                        <canvas   id="code128" style="height:0px;width:70%; margin-top:0px;margin-bottom:2px; margin-left:15px;margin-right:0;"></canvas>
                        <center><svg id="bar_id'.$n.'"></svg></center>
                    </span>

                </div>
            </div>
            ';

            //echo "<pre>";
    	//var_dump($only_barcode);
    	//echo "</pre>";
            echo '
            <script>
                JsBarcode("#bar_id'.$n.'", "'.$only_barcode.'", {
                   height: 25,
                   width: 1.5,
                   margin: 10,
                   fontSize: 11,
                });
            </script>
            ';

            $n++;
            ?>
            </div>'

    <?php
        } ?>
    </section>
    <script type="text/javascript">
      window.print();


    </script>
    <script type="text/javascript">
        $(window).on('afterprint', function () {
           window.location.href="{{ url('/slip-print-a4') }}/{{$order_ref}}/3/{{$expiry_date}}";
       });
    </script>

  </body>
</html>
