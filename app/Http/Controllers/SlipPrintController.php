<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbl_addproduct;
use App\tbl_barcode;
use App\tbl_stockin;
use App\tbl_orderrequest;
use App\Customer;
use App\ProductType;
use Session;
use Carbon\Carbon;

class SlipPrintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['order_ref_no'] = DB::table('tbl_orderrequests')
            ->orderBy('id', 'desc')
            ->get();
        $data['product_types'] = ProductType::pluck('product_type','id');
        return view('print.print_page', $data);
    }

    public function store(Request $request)
    {
        $data['order_ref'] = $order_ref_no = $request->order_id;
        $data['number_of_copy'] = $number_of_copy = $request->count;
        $data['expiry_date'] = $expire_date = $request->expiry_date;



        $data['query']=$query = DB::table("tbl_orderrequests")
            ->leftjoin("tbl_customers", "tbl_orderrequests.customer_id", "=", "tbl_customers.id")
            ->select("tbl_orderrequests.*", "tbl_customers.*")
            ->where("tbl_orderrequests.order_ref_no", $order_ref_no)
            ->first();
        $data['products_id'] = json_decode($query->product_name);
        $data['product_weight'] = json_decode($query->product_weight);

        $last_batch = DB::table('tbl_slip_print')
            ->select('batch_no')
            ->orderBy('id', 'desc')
            ->first();
        if(isset($last_batch) && !empty($last_batch)){
            $last_b = explode('_', $last_batch->batch_no);
            $d = $last_b[1] + 1;
            $batch_no = date('Ymd') . '_' . $d;
        }else{
            $batch_date = date('Ymd');
            $batch_no = $batch_date.'_100001';
        }

        $insert = DB::table('tbl_slip_print')->insert(
            ['order_ref_no' => $order_ref_no,
                'customer_id' => $query->customer_id,
                'number_of_copy' => $number_of_copy,
                'batch_no' => $batch_no,
                'production_date' => date('Y-m-d H:i:s'),
                'expire_date' => date('Y-m-d', strtotime($expire_date)),
                'created_date' => date('Y-m-d H:i:s'),
            ]);
        $data['batch_no'] = $batch_no;

//        return $data;

        return view('print.slip_print', $data);

    }

    public function slip_print_a4($order_id,$count,$expiry_date)
    {
        $order_ref_no = $order_id;
        $data['number_of_copy'] = $count;
        $data['expiry_date'] = $expire_date = $expiry_date;



        $data['query']=$query = DB::table("tbl_orderrequests")
            ->leftjoin("tbl_customers", "tbl_orderrequests.customer_id", "=", "tbl_customers.id")
            ->select("tbl_orderrequests.*", "tbl_customers.*")
            ->where("tbl_orderrequests.order_ref_no", $order_ref_no)
            ->first();
        $data['products_id'] = json_decode($query->product_name);
        $data['product_weight'] = json_decode($query->product_weight);

        $last_batch = DB::table('tbl_slip_print')
            ->select('batch_no')
            ->orderBy('id', 'desc')
            ->first();
        if(isset($last_batch) && !empty($last_batch)){
            $last_b = explode('_', $last_batch->batch_no);
            $d = $last_b[1];
            $batch_no = date('Ymd') . '_' . $d;
        }else{
            $batch_date = date('Ymd');
            $batch_no = $batch_date.'_100001';
        }
        $data['batch_no'] = $batch_no;

//        return $data;

        return view('print.slip_print_a4', $data);

    }



    public function slip_print_report(){
        $all_slip_report = DB::table('tbl_slip_print')
            ->leftJoin('tbl_customers', 'tbl_slip_print.customer_id', '=', 'tbl_customers.id')
            ->whereDate('tbl_slip_print.created_date', Carbon::today())
            ->select(['tbl_customers.company_name','tbl_slip_print.order_ref_no','tbl_slip_print.batch_no','tbl_slip_print.number_of_copy','tbl_slip_print.production_date','tbl_slip_print.expire_date','tbl_slip_print.created_date',DB::raw('sum(number_of_copy) as all_Qty')])
            ->groupBy('tbl_slip_print.order_ref_no')
            ->orderBy('tbl_slip_print.id', 'desc')
            ->get();


        return view('print.slip_report',compact('all_slip_report'));
    }

    public function slip_print_report_view(Request $request){
        $from = $request->from_date;
        $from = date('Y-m-d',strtotime($from));
        $from  = $from.' 00:00:00';
        $to = $request->to_date;
        $to = date('Y-m-d',strtotime($to));
        $to  = $to.' 23:59:59';

        $all_slip_report = DB::table('tbl_slip_print')
            ->leftJoin('tbl_customers', 'tbl_slip_print.customer_id', '=', 'tbl_customers.id')
            ->select(['tbl_customers.company_name','tbl_slip_print.order_ref_no','tbl_slip_print.batch_no','tbl_slip_print.number_of_copy','tbl_slip_print.production_date','tbl_slip_print.expire_date','tbl_slip_print.created_date',DB::raw('sum(number_of_copy) as all_Qty')])
            ->whereBetween('tbl_slip_print.created_date',[$from,$to])
            ->groupBy('tbl_slip_print.order_ref_no')
            ->orderBy('tbl_slip_print.id', 'desc')
            ->get();


        return view('print.slip_report',compact('all_slip_report'));
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
