{{-- <!DOCTYPE html> --}}
<html>
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{asset('public/admin/vendor/barcode/js/jquery-3.2.1.slim.min.js')}}"></script>
    <script src="{{asset('public/admin/vendor/barcode/js/JsBarcode.all.min.js')}}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/jsbarcode/3.3.20/JsBarcode.all.min.js"></script>  -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css" media="print">
        .barcode_jk {
            float: left;
            text-align: left;
            width: 80%;
            /*margin-bottom: 25px;
            padding: 0;
            */
            height: auto;
            margin: 0 auto;
        }

        .barcode_jk {
            margin-bottom: 30px;
        }

        .barcode_jk p {
            text-align: center;
            width: 100%;
            margin: 0 auto;
        }

        .barcode_jk span {
            text-align: center;
            font-size: 8px;
            font-weight: 700;
            margin: 0;
            padding: 0;
            padding-left: 30px
        }

        a[href]:after {
            content: none !important;
        }

        @media print {
            @page {
                size: auto;   /* auto is the initial value */
                margin: 0mm;  /* this affects the margin in the printer settings */
            }

            html, body {
                margin: 0px !important;
                padding: 0px !important;
            }

            footer {
                display: none;
                position: fixed;
                bottom: 0;
            }

            header {
                display: none;
                position: fixed;
                top: 0;
            }

            a[href]:after {
                content: none !important;
            }
        }

    </style>
</head>
<body>
<?php
$n = 0;
$com_name = "-- Best Mix --";
$p_date = Date('d-m-Y  H:i:s');
$p_date = "Print: ".$p_date;
?>
<div class="barcode_jk">
    <div class="barcode_jk_sub">
        <p>
            <center><span style="margin-top:12px;font-size:10px;display: inline-block;font-family:bestmixFont">BESTMIX (BD) LIMITED</span></center>
            <center><span style="margin-left:-5px;"><svg id="code128"></svg></span></center>

            <center><span style="margin-left:0px;margin-right:0px;font-size:12px; margin-bottom:0px;">{{$order_ref_no}}</span></center>
            <span style="float:right;font-size:7px;margin-top:15px;display:inline-block;"><i><?php echo $p_date ?></i></span>

        </p>
    </div>
</div>

<script>
    JsBarcode("#code128", "<?php echo $unique_id; ?>", {
        height: 18,
        width: 0.7,
        margin: 10,
        fontSize: 9,
    });

</script>



<script type="text/javascript">
    //window.print();
    window.onload = function () {
        self.print();
    }
    //window.onfocus=function(){ window.close();}

    $(window).on('afterprint', function () {
        window.close();
    });


</script>
