<?php

namespace App\Http\Controllers;

use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbl_addproduct;
use App\tbl_barcode;
use App\tbl_stockin;
use App\Stockout;
use App\Supplier;
use App\tbl_orderrequest;
use App\Fail_stockout;
use Session;
use Carbon\Carbon;
use Auth;
use App\Deleted_log;


class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        //
    }



    /* Start Add Product */

    public function addproduct()
    {
        //
        $data['show_product']=tbl_addproduct::orderby('id','desc')->get();
        //$data['show_product'] = tbl_addproduct::paginate(2);
        $data['product_types'] = ProductType::all();
        return view('warehouse.addproduct',$data);
    }

    public function filter_product(Request $request){

        $type = $request->filter_product_type;
        $data['show_product']=tbl_addproduct::orderby('id','desc')->where('product_type',$type)->get();
        //$data['show_product'] = tbl_addproduct::paginate(2);
        $data['product_types'] = ProductType::all();
        return view('warehouse.addproduct',$data);
    }

    public function storeaddproduct(Request $request){

         $p_name=strtoupper($request->get('product_name'));
         $p_type=strtoupper($request->get('product_type'));
         $lastdata=tbl_addproduct::all()->last();
         $lastproductid=$lastdata['id']+1;
        $todaydate = date("Ym", time());


        /// product code making start here //
        $type = ProductType::find($p_type);
        $type_name = $type->product_type;
        $typeFirst = str_split($type_name, 3);
        if($lastproductid < 100){
            $typecode = $typeFirst[0]."00".$lastproductid;
        }
        else if($lastproductid >= 100){
            $typecode = $typeFirst[0]."0".$lastproductid;
        }
        else{
            $typecode = $typeFirst[0].$lastproductid;
        }
        /// product code making START here //

        $sendBarcode = $todaydate.$typecode;

        // exit();
        // $request->product_name;
         $addproduct = new tbl_addproduct([
            'product_name' => $p_name,
            'product_type' => $p_type,
            'product_code'=> $typecode,
            'product_barcode'=> $sendBarcode
          ]);


           $count = DB::table('tbl_addproducts')->where('product_name', $p_name)
          ->count();
            if($count > 0){
                Session::flash('message', 'Sorry! Alreday This Product Name Taken');
                Session::flash('alert-class', 'btn-danger');
            }else{
            //echo "no";
            //DB::table('teammembersall')->insert($data);
                $inserted=$addproduct->save();
                if ($inserted){
                Session::flash('message', 'Successfully Added Data !');
                Session::flash('alert-class', 'btn-success');
                }else{
                Session::flash('message', 'Fail to Added Data !');
                Session::flash('alert-class', 'btn-danger');
                }
            }
            $sendBarcode = $typecode;

           // exit();
         // return redirect('/addproduct');
        return view('warehouse.product_barcode_print', compact('sendBarcode','p_name'));
    }

    public function reprint_product_code($id){
        if($id != ''){
            $products = tbl_addproduct::where('product_code',$id)->first();
            $p_name = $products->product_name;
            $p_name = $products->product_name;
            $sendBarcode = $id;
            return view('warehouse.product_barcode_print', compact('sendBarcode','p_name','products'));
        }
        else{
            return view('warehouse.addproduct');
        }
    }


    public function editproduct($id){
        $data['show_product']=tbl_addproduct::all()->sortByDesc("id");
        $data['edit_products'] =tbl_addproduct::find($id);
        $data['product_types'] = ProductType::pluck('product_type','id');
        return view('warehouse.editproduct',$data);
    }


    public function updateaddproduct(Request $request){

        $p_type = ProductType::find($request->product_type);
        $firstCode = str_split($p_type->product_type, 3);

        $p_reCode = $request->product_code;
        $getLast = str_split($p_reCode, 3);
        // $lastCode = $getLast[1];

        $p_reCode = $firstCode[0].$getLast[1];


        $id= $request->product_update_id;
        $editproduct =tbl_addproduct::find($id);
		$editproduct->product_name= strtoupper($request->product_name);
		$editproduct->product_type= $request->product_type;
		$editproduct->product_code = $p_reCode;

        $count = DB::table('tbl_addproducts')->where('product_name', $request->product_name)->where('product_type',$request->product_type )
        ->count();
        if($count > 0){
            Session::flash('message', 'This Product Name Already Taken, Updated Try Another Name ! Thanks ');
            Session::flash('alert-class', 'btn-success');
        }else{
            $updateproduct = $editproduct->update();
            if ($updateproduct){
                Session::flash('message', 'Successfully Update Data !');
                Session::flash('alert-class', 'btn-info');
               }else{
                Session::flash('message', 'Fail to Update Data !');
                Session::flash('alert-class', 'btn-danger');
              }
        }
        //exit();
        return redirect('/addproduct');
    }


    public function productdelete($id){
      $user_id = Auth::user()->user_id;
      $curDateTime = Date('Y-m-d H:i:s');
      $oldData = tbl_addproduct::find($id);
      $delData = new Deleted_log;
      $delData->delete_id = $id;
      $delData->type = 'Operation/Product';
      $delData->delete_by = $user_id;
      $delData->delete_date = $curDateTime;
      $delData->delete_data =  "$oldData->product_name".'/'."$oldData->product_code";
      $delData->save();

        $product =tbl_addproduct::find($id);
        $deleteproduct=$product ->delete();
        if ($deleteproduct){
            Session::flash('message', 'Successfully Deleted Data !');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Fail to Delete Data !');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/addproduct');
    }

   /* end product */


   public function productdetails(){
    $product_type = ProductType::pluck('product_type', 'id');
    return view('warehouse.showproduct',compact('product_type'));
   }


   public function productdetails_view(Request $request){
    $data['proType'] = ProductType::select('id','product_type')->where('id',$request->product_type)->first();

    $data['show_product']=tbl_addproduct::orderby('id','desc')->where('product_type',$request->product_type)->get();
    $data['total_qty'] = tbl_addproduct::where('product_type',$request->product_type)->sum('total_bag');
    $data['total_weight'] = tbl_addproduct::where('product_type', $request->product_type)->sum('total_weight');
    $data['total_wip'] = tbl_addproduct::where('product_type', $request->product_type)->sum('wip');
    return view('warehouse.showproduct_view',$data);
   }






    /* start bar code */

    public function productbarcode(){

        //$yesdata=tbl_barcode::all();
        ///return $yesdata;

        $showprintdata = DB::table('tbl_barcodes')
            ->leftJoin('tbl_addproducts', 'tbl_barcodes.product_id', '=', 'tbl_addproducts.id')
            ->groupBy('tbl_barcodes.print_lock')
            ->orderBy('tbl_barcodes.id', 'desc')
            ->take(5)
            ->get();

        //$show_product=json_encode($showprintdata);

       // echo "<pre>";
       // print_r($show_product);
       // exit();
        $show_product = tbl_addproduct::orderby('id','desc')->pluck('product_name','id');
        $barcodeinsertcount = tbl_barcode::count();
        $product_types = ProductType::pluck('product_type','id');
        $suppliers = Supplier::pluck('supplier_name','id');

        return view('barcode.addbarcode',compact(['showprintdata','show_product','barcodeinsertcount','product_types','suppliers']));


       // return view('barcode.addbarcode',compact());

    }


    public function ajax_product_type(Request $request){
        $p_type = $request->product_type;
        $filter_product =tbl_addproduct::orderby('id','desc')->where('product_type',$p_type)->get();
        $data = '<option value="">Product Name</option>';
        foreach ($filter_product as $products){
            $data .= '<option value="'.$products->id.'">'.$products->product_name.'</option>';
        }

        return response()->json(['data'=>$data]);

    }


    public function storebarcode(Request $request){
        $pid=$request->product_id;
        $qty=$request->product_qty;
        $request->product_weight;
        $todaydate=date("Ym", time());
        $p_name = tbl_addproduct::find($pid);

        $lastlock=tbl_barcode::all()->last();
        if(empty($lastlock)){
            $print_lock=0;
        }else{
           $print_lock=$lastlock->id;
        }
        //print_r($print_lock);
       // exit();

        $printdata=array();
        for ($x = 1; $x <= $qty; $x++) {
            //echo "The number is: $qty <br>";
           $data = new tbl_barcode();
           $lastdata=tbl_barcode::all()->last();
           if(empty($lastdata)){
                $lastid=0;
            }else{
                $lastid=$lastdata->id+1;
            }
            /// add stutic zero for maintain formate
            if($lastid < 100){
                $zero = '0000';
            }
            else if($lastid >= 100 && $lastid < 1000){
                $zero = '000';
            }
            else if($lastid >= 1000 && $lastid < 10000){
                $zero = '00';
            }
            else if($lastid >= 10000 && $lastid < 100000){
                $zero = '0';
            }
            else if($lastid >= 100000){
                $zero = '';
            }

            $data['barcode']=$todaydate.$p_name->product_code.$zero.$lastid;
            $data['product_id']=$request->product_id;
            $data['supplier_name']=$request->supplier_name;
           $data['product_name']=$p_name->product_name;
           $data['product_qty']=$request->product_qty;
           $data['product_weight']=$request->product_weight;
           $data['manufacture_date']=$request->manufacture_date;
           $data['expiry_date']=$request->expiry_date;
           $data['print_lock']=$print_lock;
           $data['status']=1;

           $inserted=$data->save();
           $printdata[]=$data;
        }
        $sendbarcode=json_encode($printdata);


        return view('barcode.barcode_print', compact('sendbarcode','p_name'));

    }

    public function barcodereprint($print_lock){
        $sendbarcode = DB::table('tbl_barcodes')
            ->where('print_lock', $print_lock)
            ->get();
        return view('barcode.barcode_print', compact('sendbarcode'));
    }



     public function barcodereport(){

        $showprintdata = DB::table('tbl_barcodes')
            ->leftJoin('tbl_addproducts', 'tbl_barcodes.product_id', '=', 'tbl_addproducts.id')
            ->groupBy('tbl_barcodes.print_lock')
            ->orderBy('tbl_barcodes.id', 'desc')
            ->get();
        // print_r($showprintdata);
       //  exit();

       return view('barcode.barcodereport',compact('showprintdata'));

     }





     /* end bar code */





     /* start stock in */

     public function stockin(){

         $show_stockdata = DB::table('tbl_stockins')
        ->leftJoin('tbl_addproducts', 'tbl_stockins.product_id', '=', 'tbl_addproducts.id')
        ->select('tbl_stockins.product_qty', DB::raw('count(tbl_stockins.product_qty) as total_product_qty'),'tbl_stockins.product_weight', DB::raw('sum(tbl_stockins.product_weight) as total_product_weight'),'tbl_addproducts.product_name')
        ->whereDate('tbl_stockins.created_at', Carbon::today())
        ->groupBy('tbl_stockins.product_id')
        ->orderBy('tbl_stockins.id', 'desc')
        ->get();

        return view('warehouse.stockin',compact('show_stockdata'));
     }



     public function ajaxRequest_stockin(Request $request){

        //$input = $request->all();
        $bar_code=$request->bar_code;
        //$bar_code_status=0;

        /*$getbarcode = DB::table('tbl_barcodes')
            ->orderBy('id', 'desc')
            ->get();
          */
        $getbarcode = DB::table('tbl_barcodes')
                         ->where('barcode', $bar_code)
                         ->where('status', 1)
                         ->first();
        if($getbarcode){
             //print_r($getbarcode);
            //$data = new tbl_stockin();
             $datastockin = new tbl_stockin([
                'barcode' => $getbarcode->barcode,
                'product_id' => $getbarcode->product_id,
                'product_qty' => 1, // single qty
                'product_weight' => $getbarcode->product_weight,
                'status' => 1,
              ]);
              $inserted_datastockin=$datastockin->save();
              $id=$getbarcode->id;
              DB::table('tbl_barcodes')
              ->where('id', $id)
              ->update(['status' => 0]);


              $pid=$getbarcode->product_id;
              $qty=1;
              $weight=$getbarcode->product_weight;

              //$getproductdata=tbl_addproduct::all();
              $getproductdata = DB::table('tbl_addproducts')
              ->where('id', $pid)
              ->first();

              //print_r($getproductdata);
              //exit();

              $total_weight=$getproductdata->total_weight;
              $total_bag=$getproductdata->total_bag;
              $alltotalweight=$weight + $total_weight;
              $alltotalbag=$qty + $total_bag;

              DB::table('tbl_addproducts')
              ->where('id', $pid)
              ->update(['total_bag' => $alltotalbag,'total_weight'=>$alltotalweight]);

              if($inserted_datastockin){
              // $show_stockdata=tbl_stockin::all()->sortByDesc("id");


               $show_stockdata = DB::table('tbl_stockins')
              ->leftJoin('tbl_addproducts', 'tbl_stockins.product_id', '=', 'tbl_addproducts.id')
              ->groupBy('tbl_stockins.product_id')
              ->orderBy('tbl_stockins.id', 'desc')
              ->get();


                $testdata=[];
                foreach($show_stockdata as $tt){
                $product_id=$tt->product_id;
                $test='
                    <tr>
                       <td>Test This One '.$product_id.'</td>
                       <td>Test This Two</td>
                       <td>Test This Three</td>
                     </tr>
                ';
                $testdata[]=$test;
               }

               // $show_stock=json_encode($show_stockdata);
                //$show_stockdata = 'yes get it';
                return response()->json(['success'=>'data insert sucess.','show'=>$testdata]);
              }else{
                return response()->json(['success'=>'data insert not sucess.']);
              }

        }else{
            return response()->json(['success'=>'no data here.']);
        }
        //var_dump($getbarcode);


     }

     public function stockin_report(){

         $todayStockIns = DB::table('tbl_stockins')
             ->leftJoin('tbl_addproducts', 'tbl_stockins.product_id', '=', 'tbl_addproducts.id')
             ->select('tbl_stockins.product_qty', DB::raw('count(tbl_stockins.product_qty) as total_product_qty'),'tbl_stockins.product_weight', DB::raw('sum(tbl_stockins.product_weight) as total_product_weight'),'tbl_addproducts.product_name','tbl_stockins.created_at')
             ->whereDate('tbl_stockins.created_at', Carbon::today())
             ->groupBy('tbl_stockins.product_id')
             ->orderBy('tbl_stockins.id', 'desc')
             ->get();


        return view('warehouse.stockin_report',compact('todayStockIns'));
     }
     public function stockin_report_view(Request $request){
         $from = $request->from_date;
         $from = date('Y-m-d',strtotime($from));
         $from  = $from.' 00:00:00';
         $to = $request->to_date;
         $to = date('Y-m-d',strtotime($to));
         $to  = $to.' 23:59:59';

         $todayStockIns = DB::table('tbl_stockins')
             ->leftJoin('tbl_addproducts', 'tbl_stockins.product_id', '=', 'tbl_addproducts.id')
             ->select('tbl_stockins.product_qty', DB::raw('count(tbl_stockins.product_qty) as total_product_qty'),'tbl_stockins.product_weight', DB::raw('sum(tbl_stockins.product_weight) as total_product_weight'),'tbl_addproducts.product_name','tbl_stockins.created_at')
             ->whereBetween('tbl_stockins.created_at',[$from,$to])
             ->groupBy('tbl_stockins.product_id')
             ->orderBy('tbl_stockins.id', 'desc')
             ->get();


         return view('warehouse.stockin_report',compact('todayStockIns'));
     }







     /* stock out */


     public function stockout(){

        $show_stockdata = DB::table('tbl_stockouts')
       ->leftJoin('tbl_addproducts', 'tbl_stockouts.product_id', '=', 'tbl_addproducts.id')
       ->select('tbl_stockouts.product_qty', DB::raw('count(tbl_stockouts.product_qty) as total_product_qty'),'tbl_stockouts.product_weight', DB::raw('sum(tbl_stockouts.product_weight) as total_product_weight'),'tbl_addproducts.product_name')
       ->whereDate('tbl_stockouts.created_at', Carbon::today())
       ->groupBy('tbl_stockouts.product_id')
       ->orderBy('tbl_stockouts.id', 'desc')
       ->get();

        //$show_product_order=tbl_orderrequest::all()->sortByDesc("id");
        //$show_product_order=tbl_orderrequest::where('status', '<', 1)->firstOrFail();

        $show_product_order = DB::table('tbl_orderrequests')
            ->where('status', 1)
            ->get();

       return view('warehouse.stockout',compact('show_stockdata','show_product_order'));
    }

    public function stockout_m(){
      return view('warehouse.stockout_m');
    }

    public function stockout_m_store(Request $request){
        $datas = $request->all();
        $user_id = Auth::user()->user_id;
        $curDate = Date('Y-m-d H:i:s');
        $selDate = strtotime($datas['selected_date']);
        $selectedDate = Date('Y-m-d',$selDate);
        $arrTemp = [];
        $succArr = [];
        $rejectArr = [];

        foreach($request->barcode as $index=>$row)
        {
          $arrTemp[$index]['barcode'] = $datas['barcode'][$index];
        }


        foreach($arrTemp as $i=>$item){

          $bar_code = $item['barcode'];

          $order_ref_no='WIP';
          $getbarcode = DB::table('tbl_stockins')
                           ->where('barcode', $bar_code)
                           ->where('status', 1)
                           ->first();

          if($getbarcode){

                $datastockout = new Stockout([
                  'barcode' => $getbarcode->barcode,
                  'order_ref_no' =>$order_ref_no,
                  'product_id' => $getbarcode->product_id,
                  'product_qty' => 1, // single qty
                  'product_weight' => $getbarcode->product_weight,
                  'user_by' => $user_id,
                  'status' => 1,
                ]);
                $inserted_datastockout=$datastockout->save();

                DB::table('tbl_stockins')
                ->where('barcode', $bar_code)
                ->update(['status' => 0]);

                $pid=$datastockout->product_id;
                $qty=1;
                $weight=$datastockout->product_weight;

                $getproductdata = DB::table('tbl_addproducts')
                ->where('id', $pid)
                ->first();

                $total_weight=$getproductdata->total_weight;
                $total_bag=$getproductdata->total_bag;
                $total_wip = $getproductdata->wip;

                $alltotalweight=$total_weight - $weight;
                $alltotalbag=$total_bag - $qty;
                $alltotalwip = $total_wip + $getbarcode->product_weight;

                if($order_ref_no == 'WIP'){
                  DB::table('tbl_addproducts')
                  ->where('id', $pid)
                  ->update(['total_bag' => $alltotalbag,'total_weight'=>$alltotalweight,'wip'=>$alltotalwip]);
                }
                else{
                  DB::table('tbl_addproducts')
                  ->where('id', $pid)
                  ->update(['total_bag' => $alltotalbag,'total_weight'=>$alltotalweight]);
                }

                $succArr[$i]['barcode'] = $item['barcode'];
            }else{

              $rejectArr[$i]['barcode'] = $item['barcode'];
            }

        }
        foreach ($rejectArr as $reItem){
          Fail_stockout::create([
                  'barcode' =>  $reItem['barcode'],
                  'fail_by' =>  $user_id,
                  'fail_date' =>  $curDate,
              ]);
        }


        $total_fail_data = Fail_stockout::where('fail_by',$user_id)
          ->whereDate('fail_date', Date('y-m-d'))
          ->get();
        $total_fail_data = count($total_fail_data);
        //echo 'Total F'.$total_fail_data;

        $total_save = Stockout::whereDate('created_at', Date('Y-m-d'))
                  ->where('user_by',$user_id)
                  ->get();
        $total_save = count($total_save);
        $recent_saved = count($succArr);
        $recent_failed = count($rejectArr);

        return response()->json(['reject'=>$rejectArr,'total_save'=>$total_save,'total_fail'=>$total_fail_data,'rec_save'=>$recent_saved,'rec_fail'=>$recent_failed]);
}

    public function Onload_stockout_m_store(){
        $user_id = Auth::user()->user_id;
        $curDate = Date('Y-m-d');


        $total_fail_data = Fail_stockout::where('fail_by',$user_id)
          ->whereDate('fail_date', Date('y-m-d'))
          ->get();
        $total_fail_data = count($total_fail_data);
        //echo 'Total F'.$total_fail_data;

        $total_save = Stockout::whereDate('created_at', Date('Y-m-d'))
                  ->where('user_by',$user_id)
                  ->get();
        $total_save = count($total_save);

        return response()->json(['total_fail'=>$total_fail_data,'total_save'=>$total_save]);
    }



    public function ajaxRequest_stockout(Request $request){

        $bar_code=$request->bar_code;
        $order_ref_no=$request->order_ref_no;
        $getbarcode = DB::table('tbl_stockins')
                         ->where('barcode', $bar_code)
                         ->where('status', 1)
                         ->first();
        if($getbarcode){

              $datastockout = new Stockout([
                'barcode' => $getbarcode->barcode,
                'order_ref_no' =>$order_ref_no,
                'product_id' => $getbarcode->product_id,
                'product_qty' => 1, // single qty
                'product_weight' => $getbarcode->product_weight,
                'status' => 1,
              ]);
              $inserted_datastockout=$datastockout->save();

              DB::table('tbl_stockins')
              ->where('barcode', $bar_code)
              ->update(['status' => 0]);

              $pid=$datastockout->product_id;
              $qty=1;
              $weight=$datastockout->product_weight;

              $getproductdata = DB::table('tbl_addproducts')
              ->where('id', $pid)
              ->first();

              $total_weight=$getproductdata->total_weight;
              $total_bag=$getproductdata->total_bag;
              $total_wip = $getproductdata->wip;

              $alltotalweight=$total_weight - $weight;
              $alltotalbag=$total_bag - $qty;
              $alltotalwip = $total_wip + $getbarcode->product_weight;

              if($order_ref_no == 'WIP'){
                DB::table('tbl_addproducts')
                ->where('id', $pid)
                ->update(['total_bag' => $alltotalbag,'total_weight'=>$alltotalweight,'wip'=>$alltotalwip]);
              }
              else{
                DB::table('tbl_addproducts')
                ->where('id', $pid)
                ->update(['total_bag' => $alltotalbag,'total_weight'=>$alltotalweight]);
              }



            return response()->json(['success'=>'data insert sucess.','show'=>$getbarcode]);
        }else{
            return response()->json(['success'=>'no data here.']);
        }
    }



    public function stockout_report(){

        $todayStockOuts = DB::table('tbl_stockouts')
            ->leftJoin('tbl_addproducts', 'tbl_stockouts.product_id', '=', 'tbl_addproducts.id')
            ->select('tbl_stockouts.product_qty', DB::raw('count(tbl_stockouts.product_qty) as total_product_qty'),'tbl_stockouts.product_weight', DB::raw('sum(tbl_stockouts.product_weight) as total_product_weight'),'tbl_addproducts.product_name','tbl_stockouts.created_at')
            ->whereDate('tbl_stockouts.created_at', Carbon::today())
            ->groupBy('tbl_stockouts.product_id')
            ->orderBy('tbl_stockouts.id', 'desc')
            ->get();

        return view('warehouse.stockout_report',compact('todayStockOuts'));

    }
    public function stockout_report_view(Request $request){
        $from = $request->from_date;
        $from = date('Y-m-d',strtotime($from));
        $from  = $from.' 00:00:00';
        $to = $request->to_date;
        $to = date('Y-m-d',strtotime($to));
        $to  = $to.' 23:59:59';

        $todayStockOuts = DB::table('tbl_stockouts')
            ->leftJoin('tbl_addproducts', 'tbl_stockouts.product_id', '=', 'tbl_addproducts.id')
            ->select('tbl_stockouts.product_qty', DB::raw('count(tbl_stockouts.product_qty) as total_product_qty'),'tbl_stockouts.product_weight', DB::raw('sum(tbl_stockouts.product_weight) as total_product_weight'),'tbl_addproducts.product_name','tbl_stockouts.created_at')
            ->whereBetween('tbl_stockouts.created_at',[$from,$to])
            ->groupBy('tbl_stockouts.product_id')
            ->orderBy('tbl_stockouts.id', 'desc')
            ->get();

        return view('warehouse.stockout_report',compact('todayStockOuts'));

    }









}
