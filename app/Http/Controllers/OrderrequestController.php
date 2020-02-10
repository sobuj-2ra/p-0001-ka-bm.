<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbl_addproduct;
use App\tbl_barcode;
use App\tbl_stockin;
use App\tbl_orderrequest;
use App\Formula;
use App\Customer;
use App\ProductType;
use App\tbl_orderrequest_history;
use Session;
use Carbon\Carbon;
use Auth;
use App\Deleted_log;

class OrderrequestController extends Controller
{
    //

    public function order_request()
    {
        $show_product = tbl_addproduct::all()->sortByDesc("id");
        $customer = Customer::all()->sortByDesc("id");

        $show_formula = DB::table('tbl_addformula')
            ->groupBy('formula_name')
            ->orderBy('id', 'desc')
            ->get();
        $formula_types = ProductType::pluck('product_type','id');
        return view('warehouse.order_request', compact(['show_product', 'customer', 'show_formula','formula_types']));
    }




    public function ajax_order_request_f_type(Request $request){
        $f_type = $request->f_type;
        $filter_formulas = Formula::orderby('id','desc')
            ->groupBy('formula_name')
            ->where('f_type',$f_type)
            ->get();

        $data = '<option>Select Formula</option>';
        foreach ($filter_formulas as $filter_formula){
            $data .= '<option value="'.$filter_formula->formula_name.'">'.$filter_formula->formula_name.'</option>';
        }


        $filter_show_products = tbl_addproduct::orderby('id','desc')->where('product_type',$f_type)->get();

        $products = '<option>Select Product</option>';
        foreach ($filter_show_products as $filter_show_product){
            $products .= '<option value="'.$filter_show_product->id.'">'.$filter_show_product->product_name.'</option>';
        }

        return response()->json(['data'=>$data,'products'=>$products]);
    }

    public function ajax_order_request_filter_product_type(Request $request){
        $f_type = $request->f_type;

        $filter_show_products = tbl_addproduct::orderby('id','desc')->where('product_type',$f_type)->get();

        $products = '<option>Select Product</option>';
        foreach ($filter_show_products as $filter_show_product){
            $products .= '<option value="'.$filter_show_product->id.'">'.$filter_show_product->product_name.'</option>';
        }

        return response()->json(['products'=>$products]);
    }


    public function store_order_request(Request $request)
    {

        $checkproduct = $request->product_name;
        $get_checkproduct = count($checkproduct);
        if ($get_checkproduct > 0) {
            //echo "yes data";
            $customer_id = $request->customer_id;
            $order_ref_no = $request->order_ref_no;
            $ref_type = $request->formula_type;
            $request_date = $request->request_date;
            $product_name = json_encode($request->product_name);
            $product_weight = json_encode($request->product_weight);

            $count = DB::table('tbl_orderrequests')->where('order_ref_no', $order_ref_no)
                ->count();
            if ($count > 0) {
                Session::flash('message', 'Sorry!This Order Ref/No Alreday Taken');
                Session::flash('alert-class', 'btn-danger');
                return redirect('/order_request');
            } else {

                $addorder = new tbl_orderrequest([
                    'customer_id' => $customer_id,
                    'order_ref_no' => $order_ref_no,
                    'ref_type' => $ref_type,
                    'request_date' => $request_date,
                    'product_name' => $product_name,
                    'product_weight' => $product_weight,
                    'status' => 1,
                ]);
                $insert = $addorder->save();


//                        $historyarray = array();
//                        for ($i=0; $i <count($checkproduct) ; $i++){
//                            $historyarray[] = array(
//                                'product_name' => $request->product_name[$i],
//                                'product_weight' => $request->product_weight[$i],
//                                'unit_name' => $request->unit_name[$i],
//                                'customer_id' => $customer_id,
//                                'order_ref_no' => $order_ref_no
//                            );
//                        }
//                        DB::table('tbl_orderrequests_history')->insert($historyarray);


                if ($insert) {
                    Session::flash('message', 'WoW! Successfully Insert Data.');
                    Session::flash('alert-class', 'btn-success');
                    return redirect('/order_request');
                } else {
                    Session::flash('message', 'Fail! Data Insert Not Successfully');
                    Session::flash('alert-class', 'btn-danger');
                    return redirect('/order_request');
                }
            }
        } else {
            // echo "no data";
            Session::flash('message', 'Sorry! Please Add Product Name And Product weight');
            Session::flash('alert-class', 'btn-danger');
            return redirect('/order_request');
        }

    }

    public function order_request_view(){
      $orderReqData = tbl_orderrequest::all();
      return view('warehouse.order_request_view',compact('orderReqData'));
    }
    public function order_request_destroy($id){
      $is_destroy = Tbl_orderrequest::find($id);
      $is_data = tbl_orderrequest_history::where('order_ref_no',$is_destroy->order_ref_no)->get();
      if(count($is_data) < 1){

        $user_id = Auth::user()->user_id;
        $curDateTime = Date('Y-m-d H:i:s');
        $oldData = Tbl_orderrequest::find($id);
        $delData = new Deleted_log;
        $delData->delete_id = $id;
        $delData->type = 'Operation/OrderRequest';
        $delData->delete_by = $user_id;
        $delData->delete_date = $curDateTime;
        $delData->delete_data =  "$is_destroy->customer_id/$is_destroy->order_ref_no/$is_destroy->product_name";
        $delData->save();


        $is_destroy = $is_destroy->delete();
        if($is_destroy){
          $msg = 'Data Delete Succesfully';
          $status = 'alert-success';
        }
        else{
          $msg = 'Data Could\'n Delete';
          $status = 'alert-warning';
        }
      }
      else{
        $msg = 'Opps!! Order Request already exist';
        $status = 'alert-warning';
      }
      return redirect()->back()->with(['msg'=>$msg,'status'=>$status]);
    }




    public function order_request_report()
    {
        $show_product = DB::table('tbl_orderrequests')
            ->leftJoin('tbl_customers', 'tbl_orderrequests.customer_id', '=', 'tbl_customers.id')
            ->orderBy('tbl_orderrequests.id', 'desc')
            ->limit(100)
            ->get();

        $orders = DB:: table("tbl_orderrequests")
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
        $i = 0;
        foreach ($show_product as $item) {
            $show_product[$i]->weight = DB::table('tbl_orderrequests_history')
                ->where('order_ref_no', $item->order_ref_no)
                ->sum('product_weight');
            $i++;
        }

        return view('warehouse.show_order_request', compact(['show_product', 'orders']));
    }


    public function ajaxRequest_totalweight(Request $request)
    {

        $formula_id = $request->formula_id;
        $total_weight = $request->total_weight;

        $getdata = DB::table('tbl_addformula')
            ->leftJoin('tbl_addproducts', 'tbl_addformula.product_name', '=', 'tbl_addproducts.id')
            ->select('tbl_addformula.product_weight', 'tbl_addproducts.product_name', 'tbl_addproducts.id', 'tbl_addformula.formula_name', 'tbl_addformula.unit_name')
            ->where('tbl_addformula.formula_name', $formula_id)
            ->orderBy('tbl_addformula.id', 'desc')
            ->get();

        $getdata_count = DB::table('tbl_addformula')
            ->select(DB::raw('sum(tbl_addformula.product_weight) as total_product_weight'))
            ->where('tbl_addformula.formula_name', $formula_id)
            ->get();

        $sumweight = $getdata_count[0]->total_product_weight;
        //echo "<br/>";

        $weightcalculation = $total_weight / $sumweight;

        // echo "<br/>";

        //echo "<pre>";
        // print_r($getdata);
        // echo "<br/>";

        foreach ($getdata as $show_data) {
            $product_id = $show_data->id;
            $product_name = $show_data->product_name;
            $product_weight = $show_data->product_weight;
            $unit_name = $show_data->unit_name;
            $weight = $weightcalculation * $product_weight;
            $round_weight = round($weight, 2);

            echo '
                <tr>
                    <td style="width:50%">
                    <input type="hidden" name="product_name[]" value="' . $product_id . '" class="form-control product_name" />
                    <input readonly required type="text" value="' . $product_name . '" class="form-control product_name" />
                    </td>
                    <td style="width:15%">
                    <input readonly required type="text" value="' . $product_weight . ' gm" class="form-control product_name" />
                    </td>
                    <td style="width:20%"><input readonly required type="text" name="product_weight[]" value="' . $round_weight . '" class="form-control product_weight" /></td>
                    <td style="width:10%"><input readonly required type="text" name="unit_name[]" value="' . $unit_name . '" class="form-control unit_name" /></td>
                    <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>
                </tr>
                ';


        }

    }

    public function order_report_search_by_date(Request $request)
    {
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));

        $show_product = DB::table('tbl_orderrequests')
            ->leftJoin('tbl_customers', 'tbl_orderrequests.customer_id', '=', 'tbl_customers.id')
            ->whereBetween('tbl_orderrequests.created_at', [$from_date, $to_date])
            ->get();
        $i = 0;
        foreach ($show_product as $item) {
            $show_product[$i]->weight = DB::table('tbl_orderrequests_history')
                ->where('order_ref_no', $item->order_ref_no)
                ->sum('product_weight');
            $i++;
        }


        return view('warehouse.show_order_request_by_date', compact(['show_product']));
    }

    public function search_by_reference(Request $request){
        $order_ref_no = $request->order_ref_no;
        return redirect("/details-order/$order_ref_no");
    }

    public function orders_status_report(){

        return view('warehouse.order_status_report');

    }

    public function orders_status_report_search(Request $request){
        $from = $request->from_date;
        $from = date('Y-m-d',strtotime($from));
        $from_date  = $from.' 00:00:00';
        $to = $request->to_date;
        $to = date('Y-m-d',strtotime($to));
        $to_date  = $to.' 23:59:59';


        $status = $request->status;
        $show_product = DB::table('tbl_orderrequests')
            ->leftJoin('tbl_customers', 'tbl_orderrequests.customer_id', '=', 'tbl_customers.id')
            ->whereBetween('tbl_orderrequests.created_at', [$from_date, $to_date])
            ->get();

//        $product_name = json_decode($show_product->product_name);
//        $product_weight = json_decode($show_product->product_weight);
//        $j = 0;
//        foreach ($product_name as $product) {
//            $show_product[$j]->product = DB::table('tbl_addproducts')
//                ->where('id', $product)
//                ->first();
//            $j++;
//        }
//        $total_weight = 0;
//        foreach ($product_weight as $weight) {
//            $total_weight+=$weight;
//            $show_product[$j]->weight = $total_weight;
//        }

        if ($status == 'Finish'){
            $check = $status;
            $i = 0;
            foreach ($show_product as $item) {
                $show_product[$i]->unique_number = DB::table('tbl_orderrequests_history')
                    ->where('order_ref_no', $item->order_ref_no)
                    ->having('tbl_orderrequests_history.status', '=', $check)
                    ->groupBy('unique_id')
                    ->get();
                $i++;
            }
        }elseif ($status == 'Running'){
            $check = $status;
            $i = 0;
            foreach ($show_product as $item) {
                $show_product[$i]->unique_number = DB::table('tbl_orderrequests_history')
                    ->where('order_ref_no', $item->order_ref_no)
                    ->having('tbl_orderrequests_history.status', '=', $check)
                    ->groupBy('unique_id')
                    ->get();
                $i++;
            }
        }elseif ($status == 'Ready'){
            $check = 'Active';
            $i = 0;
            foreach ($show_product as $item) {
                $show_product[$i]->unique_number = DB::table('tbl_orderrequests_history')
                    ->where('order_ref_no', $item->order_ref_no)
                    ->having('tbl_orderrequests_history.status', '=', $check)
                    ->groupBy('unique_id')
                    ->get();
                $i++;
            }
        }elseif ($status == 'Pending'){
            $i = 0;
            foreach ($show_product as $item) {
                $show_product[$i]->unique_number = DB::table('tbl_orderrequests_history')
                    ->where('order_ref_no', $item->order_ref_no)
                    ->whereNull('tbl_orderrequests_history.status')
                    ->groupBy('unique_id')
                    ->get();
                $i++;
            }
        }elseif ($status == 'All'){
            $i = 0;
            foreach ($show_product as $item) {
                $show_product[$i]->unique_number = DB::table('tbl_orderrequests_history')
                    ->where('order_ref_no', $item->order_ref_no)
                    ->groupBy('unique_id')
                    ->get();
                $i++;
            }
        }
        return view('warehouse.order_status_report_print', compact(['show_product','status']));

    }


}
