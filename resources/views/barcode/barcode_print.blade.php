<?php 

	 //var_dump($sendbarcode);
	$send_barcode=json_decode($sendbarcode);
  //print_r($send_barcode);
	
/*
	 for ($x = 1; $x <= $pqty; $x++) {
			echo "14";
			echo "<br/>";
			echo $barcode;
			echo "<br/>";
	 }  */
	// exit();

?>


{{-- <!DOCTYPE html> --}}
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
     
	 <script src="{{asset('public/admin/vendor/barcode/js/jquery-3.2.1.slim.min.js')}}"></script>
	 <script src="{{asset('public/admin/vendor/barcode/js/JsBarcode.all.min.js')}}"></script>
	<link rel="stylesheet" href="{{asset('public/assets/css/style.css') }}">
		 
		 
		 <!-- <script src="https://cdn.jsdelivr.net/jsbarcode/3.3.20/JsBarcode.all.min.js"></script>  -->

	<meta name="csrf-token" content="{{ csrf_token() }}">



<style type="text/css" media="print">




	.barcode_jk{
		float: left;
		text-align: left;
		width: 80%;
		/*margin-bottom: 25px;
		padding: 0;
		*/
		height:auto;
		margin: 0 auto;
	}


	.barcode_jk{
		margin-bottom: 30px;
	}

	.barcode_jk p{
		text-align: center;
		width: 100%;
		margin: 0 auto;
	}

	.barcode_jk span{
		text-align:center;
		font-size: 8px;
		font-weight:700;
		margin: 0;
		padding: 0;
		padding-left:30px
	}

	a[href]:after {
     content: none !important;
   }


	@media print  
		{


		  	


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

// var_dump($send_barcode);
set_time_limit(0);
$n=0;
$p_date = Date('d-m-Y  h:i:s A');
$p_date = "Print: ".$p_date;

foreach($send_barcode as $get_barcode){

	//echo $n;

	//print_r($get_barcode);
	$only_barcode= $get_barcode->barcode;
	//exit();
	
	//$only_barcode=$get_barcode['barcode'];
	//$batch_no=$get_barcode['batch_no'];

	echo '
	<div class="barcode_jk">
	<div class="barcode_jk_sub">
		<p>
			<center><span style="margin-top:12px;font-size:10px;display: inline-block;font-family:bestmixFont">BESTMIX (BD) LIMITED</span></center>
			<center><span style="margin-left:-20px;display:block"><svg id="code128'.$n.'"></svg></span></center>
			<center><span style="font-size:12px; margin-bottom:0px;">'.$get_barcode->product_name.'</span></center>
			<span style="float:left;font-size:7px;margin-top:13px;display:inline-block;"><i>Mfg: '.$get_barcode->manufacture_date.' / Exp: '.$get_barcode->expiry_date.'</i></span>
		</p>

	</div>
	</div>
	';

	//echo "<pre>";
	//var_dump($only_barcode);
	//echo "</pre>";
			echo '
		   <script>

				 JsBarcode("#code128'.$n.'", "'.$only_barcode.'", {
					   height: 22,
					   width: 0.9,
					   margin: 10,
					   fontSize: 9,
				  });


			</script>
		 ';

	 $n++;
}


?>










<script type="text/javascript">


//window.print();
window.onload=function(){self.print();} 
//window.onfocus=function(){ window.close();}

$(window).on('afterprint', function () {
   window.location.href="{{ url("/productbarcode") }}";
});


</script>



