<?php

namespace App\Http\Controllers;

use App\BatcherHistory;
use App\tbl_orderrequest_history;
use App\WeightMachine;
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


class BatcherController extends Controller
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


    public function batcherindex()
    {
        //
        $show_product_order = DB::table('tbl_orderrequests')
            ->where('status', 1)
            ->get();
        $product_types = ProductType::pluck('product_type','id');
        return view('batcher.addbatcher', compact(['show_product_order','product_types']));
    }

    public function ajax_order_request_r_type(Request $request){

        $ref_type = $request->r_type;

        if($ref_type == null){
            $show_order_refs = DB::table('tbl_orderrequests')
                ->where('status', 1)
                ->get();

            $data = '<option value="">Select Ref Name</option>';
            foreach ($show_order_refs as $show_order_ref){
                $data .= '<option value="'.$show_order_ref->order_ref_no.'">'.$show_order_ref->order_ref_no.'</option>';
            }
        }
        else{
            $show_order_refs = DB::table('tbl_orderrequests')
                ->where('status', 1)
                ->where('ref_type', $ref_type)
                ->get();

            $data = '<option value="">Select Ref Name</option>';
            foreach ($show_order_refs as $show_order_ref){
                $data .= '<option value="'.$show_order_ref->order_ref_no.'">'.$show_order_ref->order_ref_no.'</option>';
            }
        }
        return response()->json(['data'=>$data]);
    }

    public function batcher_store(Request $request)
    {
        $order_ref_no = $request->order_ref_no;
        $get_data = DB::table('tbl_orderrequests')
            ->where('order_ref_no', $order_ref_no)
            ->first();
        $product_id = json_decode($get_data->product_name);
        $product_weights = json_decode($get_data->product_weight);

        $get_last_unique_id = DB::table('tbl_orderrequests_history')
            ->orderBy('id', 'desc')
            ->first();
        if (isset($get_last_unique_id->unique_id) && !empty($get_last_unique_id->unique_id)) {
            $last_digit = explode('_', $get_last_unique_id->unique_id);
            $d = $last_digit[1] + 1;
            $unique_id = date('Ymd') . '_' . $d;
        } else {
            $date_now = date('Ymd');
            $unique_id = $date_now . '_100001';
        }
        $p_type = tbl_addproduct::find($product_id[0]);
        $p_type = ProductType::where('id', $p_type->product_type)->first();


        $j = 0;
        foreach ($product_id as $product) {
            $cus_id = $get_data->customer_id;
            $insert_new_batcher = DB::table('tbl_orderrequests_history')->insert(
                ['unique_id' => $unique_id,
                    'order_ref_no' => $order_ref_no,
                    'customer_id' => $cus_id,
                    'product_name' => $product,
                    'ref_type' => $p_type->id,
                    'product_weight' => $product_weights[$j],
                    'unit_name' => 'Gram',
                    'created_at' => Date('Y-m-d H:i:s')
                ]);
            $j++;
        }

        $insert_new_troli = DB::table('tbl_troli')->insert(
            ['unique_id' => $unique_id,
                'order_ref_no' => $order_ref_no,
                'customer_id' => $cus_id,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        $insert_queue_list = DB::table('tbl_queue_list')->insert(
            ['unique_id' => $unique_id,
                'order_ref_no' => $order_ref_no,
                'customer_id' => $cus_id,
                'machine_id' => NULL,
                'queue_no' => NULL,
                'status' => 1,
            ]);
        return redirect("/showbatcher/$order_ref_no/$unique_id");

    }


    public function showbatcher($order_ref_no,$unique_id)
    {



        $show_all_data = DB::table('tbl_orderrequests_history')
            ->leftJoin('tbl_addproducts', 'tbl_orderrequests_history.product_name', '=', 'tbl_addproducts.id')
            ->select('tbl_orderrequests_history.order_ref_no', 'tbl_orderrequests_history.id', 'tbl_orderrequests_history.product_weight', 'tbl_orderrequests_history.status', 'tbl_addproducts.product_name')
            ->where('tbl_orderrequests_history.order_ref_no', $order_ref_no)
            ->Where('tbl_orderrequests_history.unique_id', $unique_id)
            ->get();


        $show_one_data = DB::table('tbl_orderrequests_history')
            ->leftJoin('tbl_addproducts', 'tbl_orderrequests_history.product_name', '=', 'tbl_addproducts.id')
            ->select('tbl_orderrequests_history.order_ref_no', 'tbl_orderrequests_history.id', 'tbl_orderrequests_history.product_weight', 'tbl_orderrequests_history.status', 'tbl_addproducts.product_name')
            ->where('tbl_orderrequests_history.order_ref_no', $order_ref_no)
            ->Where('tbl_orderrequests_history.unique_id', $unique_id)
            ->Where('tbl_orderrequests_history.status', NULL)
            ->orderBy('tbl_orderrequests_history.id', 'desc')
            ->take(1)
            ->get();

        $weight_machines = WeightMachine::all();


        $ref_no =  tbl_orderrequest::where('order_ref_no',$order_ref_no)->first();
        $machine_id = ProductType::where('id', $ref_no->ref_type)->first();
        $weight_machineData = WeightMachine::where('id', $machine_id->machine_id)->first();




        return view('batcher.checkbatcher', compact(['show_all_data', 'show_one_data', 'order_ref_no', 'unique_id','weight_machines','ref_no','weight_machineData']));

    }

    public function print_barcode_unique($order_ref_no, $unique_id){

        $batchHis = BatcherHistory::where('order_ref', $order_ref_no)->where('unique_id',$unique_id)->get();
        if(count($batchHis)<1){
            $batchHis = BatcherHistory::where('order_ref', $order_ref_no)->where('unique_id',$unique_id)->get();
            if(count($batchHis) < 1){
                $batcher_history = new BatcherHistory();
                $batcher_history->order_ref = $order_ref_no;
                $batcher_history->unique_id = $unique_id;
                $is_save = $batcher_history->save();
            }
            $show_all_data = DB::table('tbl_orderrequests_history')
                ->leftJoin('tbl_addproducts', 'tbl_orderrequests_history.product_name', '=', 'tbl_addproducts.id')
                ->select('tbl_orderrequests_history.order_ref_no', 'tbl_orderrequests_history.product_weight', 'tbl_orderrequests_history.status', 'tbl_addproducts.id')
                ->where('tbl_orderrequests_history.order_ref_no', $order_ref_no)
                ->Where('tbl_orderrequests_history.unique_id', $unique_id)
                ->get();
            $dataArr = [];
            foreach ($show_all_data as $i=>$item) {
              $proData = tbl_addproduct::find($item->id);
              //echo "old : ".$proData->wip." new:".$item->product_weight." name: ".$proData->product_name."<br> ";
              $oldWip = $proData->wip;
              $pid = $proData->id;
              $divData = $item->product_weight/1000;
              $subData = $oldWip-$divData;
                //echo $subData." ".$oldWip." ; ";
              $productData = tbl_addproduct::find($pid);
              $productData->wip = $subData;
              $is_save = $productData->Update();
            }
          }
        return view('batcher.print_barcode_unique', compact(['order_ref_no','unique_id']));
    }

    public function batcher_reprint_barcode($order_ref_no, $unique_id){
        return view('batcher.batcher_reprint_barcode', compact(['order_ref_no','unique_id']));
    }


    public function batcher_reprint(){
        $all_batch_his = BatcherHistory::orderby('id','desc')->get();
        return view('batcher.batcher_history',compact('all_batch_his'));

    }

    public function batcher_report(){

        $all_batch_report = DB::table('tbl_orderrequests_history')
            ->leftJoin('tbl_addproducts', 'tbl_orderrequests_history.product_name', '=', 'tbl_addproducts.id')
            ->leftJoin('product_type', 'tbl_orderrequests_history.ref_type', '=', 'product_type.id')
            ->leftJoin('tbl_customers', 'tbl_orderrequests_history.customer_id', '=', 'tbl_customers.id')
            ->select('tbl_orderrequests_history.product_name', DB::raw('count(tbl_orderrequests_history.product_name) as total_product_qty'),'tbl_orderrequests_history.product_weight', DB::raw('sum(tbl_orderrequests_history.product_weight) as total_product_weight'),'tbl_addproducts.product_name','tbl_orderrequests_history.order_ref_no','tbl_orderrequests_history.created_at','tbl_customers.company_name')
            ->whereDate('tbl_orderrequests_history.created_at', Carbon::today())
            ->groupBy('tbl_orderrequests_history.order_ref_no')
            ->orderBy('tbl_orderrequests_history.id', 'desc')
            ->get();


        return view('batcher.batcher_report',compact('all_batch_report'));
    }

    public function batcher_report_view(Request $request){

        $from = $request->from_date;
        $from = date('Y-m-d',strtotime($from));
        $from  = $from.' 00:00:00';
        $to = $request->to_date;
        $to = date('Y-m-d',strtotime($to));
        $to  = $to.' 23:59:59';


        $all_batch_report = DB::table('tbl_orderrequests_history')
            ->leftJoin('tbl_addproducts', 'tbl_orderrequests_history.product_name', '=', 'tbl_addproducts.id')
            ->leftJoin('product_type', 'tbl_orderrequests_history.ref_type', '=', 'product_type.id')
            ->leftJoin('tbl_customers', 'tbl_orderrequests_history.customer_id', '=', 'tbl_customers.id')
            ->select('tbl_orderrequests_history.product_name', DB::raw('count(tbl_orderrequests_history.product_name) as total_product_qty'),'tbl_orderrequests_history.product_weight', DB::raw('sum(tbl_orderrequests_history.product_weight) as total_product_weight'),'tbl_addproducts.product_name','tbl_orderrequests_history.order_ref_no','tbl_orderrequests_history.created_at','tbl_customers.company_name')
            ->whereBetween('tbl_orderrequests_history.created_at', [$from,$to])
            ->groupBy('tbl_orderrequests_history.order_ref_no')
            ->orderBy('tbl_orderrequests_history.id', 'desc')
            ->get();


        return view('batcher.batcher_report',compact('all_batch_report'));
    }


    public function insertbatcher(Request $request)
    {

        $product_name = $request->product_name;
        for ($i = 0; $i < count($product_name); $i++) {

            $product_id = $request->product_id[$i];
            $product_weight = $request->product_weight[$i];
            $weight_re_insert = $request->weight_re_insert[$i];

            if ($product_weight == $weight_re_insert) {

                echo "yes";

            } else {

                echo "no";

            }
            //echo "text data";
        }

        /*
        $order_ref_no=$request->order_ref_no;
        $show_all_data = DB::table('tbl_orderrequests_history')
       ->leftJoin('tbl_addproducts', 'tbl_orderrequests_history.product_name', '=', 'tbl_addproducts.id')
       ->where('tbl_orderrequests_history.order_ref_no',$order_ref_no)
       ->get();

      // print_r($show_all_data);
       return view('batcher.checkbatcher',compact(['show_all_data']));
       */
    }


    public function ajaxRequest_checkbarcode(Request $request)
    {
        $barcode = $request->barcode;
        $p_name = $request->p_name;
        $p_weight = $request->p_weight/1000;

        $getbarcode = tbl_addproduct::where('product_code', $barcode)
            ->where('product_name',$p_name)
            ->first();
        if($p_weight <= $getbarcode->wip){
          if($getbarcode) {
            // echo "yes match this barcode";
            return response()->json(['success' => 'Product Accepted', 'check' => '0']);
          }else{
            // echo "no match data";
            return response()->json(['success' => 'Sorry! Product Not Accepted.', 'check' => '1']);
          }
        }
        else{
          return response()->json(['success' => 'Not Sufficient Product. Please Stock Out', 'check' => '1']);
        }

    }


    public function ajaxRequest_productweight(Request $request)
    {
        $get_product_weight = $request->get_product_weight;
        $get_id = $request->get_id;
        $product_weight = $request->product_weight;
        $getbarcodeweight = DB::table('tbl_orderrequests_history')
            ->where('id', $get_id)
            ->where('product_weight', $product_weight)
            ->first();
        if ($getbarcodeweight) {
            // echo "yes match this barcode";

            DB::table('tbl_orderrequests_history')
                ->where('id', $get_id)
                ->update(['status' => 'Active']);

            return response()->json(['success' => 'Weight Accepted', 'check' => '0']);
        } else {
            // echo "no match data";
            return response()->json(['success' => 'Sorry! Weight Not Accepted.', 'check' => '1']);
        }
    }

    public function batcher_production()
    {
        $data = array();
        $ref_array = array();
        $data['lists'] = $lists = DB::select("SELECT SUM(tbl_orderrequests_history.product_weight) AS weight, tbl_orderrequests_history.*,tbl_customers.id,tbl_customers.company_name,tbl_customers.head_contact_name,tbl_customers.head_address,tbl_customers.factory_contact_person_name,tbl_customers.factory_phone_number,tbl_orderrequests.order_ref_no,tbl_queue_list.order_ref_no,tbl_queue_list.unique_id,tbl_queue_list.machine_id,tbl_queue_list.queue_no,tbl_queue_list.status FROM tbl_orderrequests_history INNER JOIN tbl_customers ON tbl_customers.id = tbl_orderrequests_history.customer_id INNER JOIN tbl_orderrequests ON tbl_orderrequests.order_ref_no=tbl_orderrequests_history.order_ref_no INNER JOIN tbl_queue_list ON tbl_queue_list.unique_id = tbl_orderrequests_history.unique_id WHERE tbl_queue_list.machine_id IS NULL AND tbl_queue_list.queue_no is NULL AND tbl_queue_list.status = 1 GROUP BY tbl_orderrequests_history.`unique_id` HAVING tbl_orderrequests_history.`status` = 'Active' ORDER BY tbl_orderrequests_history.id ASC");

        $data['machines'] = $machines = $machine_datas = DB::table('tbl_addmachine')
            ->where('status', 1)
            ->get();

        $k = 0;
        foreach ($machine_datas as $mach) {
            $machine_datas[$k]->machine = DB::table('tbl_queue_list')
                ->select('*')
                ->join('tbl_addmachine', 'tbl_addmachine.id', '=', 'tbl_queue_list.machine_id')
                ->where('tbl_queue_list.machine_id', $mach->id)
                ->where('tbl_queue_list.status', 2)
                ->first();
            $k++;
        }
        $data['machine_datas'] = $machine_datas;
        $j = 0;
        foreach ($machines as $machine) {
            $machines[$j]->machine_data = DB::table('tbl_queue_list')
                ->select('*')
                ->join('tbl_addmachine', 'tbl_addmachine.id', '=', 'tbl_queue_list.machine_id')
                ->join('tbl_troli', 'tbl_troli.order_ref_no', '=', 'tbl_queue_list.order_ref_no')
                ->where('tbl_queue_list.machine_id', $machine->id)
                ->where('tbl_queue_list.status', 1)
                ->orderBy('tbl_queue_list.queue_no', 'asc')
                ->first();
            $j++;
        }

//        $data['pro_queue'] = DB::table('tbl_orderrequests')
//            ->select('*')
//            ->join('tbl_addmachine', 'tbl_addmachine.id', '=', 'tbl_orderrequests.machine_id')
//            //->where('tbl_orderrequests.queue_no', 1)
//            ->where('tbl_orderrequests.status', 1)
//            ->orderBy('tbl_orderrequests.machine_id', 'asc')
//            ->take(2)
//            ->get();
        $data['orders_count'] = sizeof($data['lists']);
        return view('batcher.manager_production', $data);
    }

    public function update_production_list(Request $request)
    {
        $machine_id = $request->machine_id;
        $queue_no = $request->queue_id;
        $order_ref_no = $request->order_ref_no;
        $unique_id = $request->unique_id;


        $current_queue = DB::table('tbl_queue_list')
            ->where('unique_id', $unique_id)
            ->first();
        if (isset($current_queue) && !empty($current_queue)) {
            $queue_list = DB::table('tbl_queue_list')
                ->where('queue_no', $queue_no)
                ->where('machine_id', $machine_id)
                ->orderBy('queue_no', 'desc')
                ->first();
            if (isset($queue_list) && !empty($queue_list)) {
                $arrData = array(
                    'queue_no' => $current_queue->queue_no,
                    //'machine_id' => $current_queue->machine_id,
                );
                $updated = DB::table('tbl_queue_list')
                    ->where('unique_id', $queue_list->unique_id)
                    ->update($arrData);

                $arr = array(
                    'queue_no' => $queue_no,
                    'machine_id' => $machine_id
                );
                $update = DB::table('tbl_queue_list')
                    ->where('unique_id', $unique_id)
                    ->update($arr);
            } else {
                $arrData = array(
                    'queue_no' => $queue_no,
                    'machine_id' => $machine_id
                );
                $updated = DB::table('tbl_queue_list')
                    ->where('unique_id', $unique_id)
                    ->update($arrData);
            }

        } else {
            $arrData = array(
                'machine_id' => $machine_id,
                'queue_no' => $queue_no,
            );
            $updated = DB::table('tbl_queue_list')
                ->where('order_ref_no', $order_ref_no)
                ->where('unique_id', $unique_id)
                ->update($arrData);
        }
        return redirect("/batcher-production");

    }

    public function details_order($ref_id)
    {
        $data = array();

        $data['pro_details'] = DB::table('tbl_orderrequests_history')
            ->select('*')
            ->join('tbl_addproducts', 'tbl_addproducts.id', '=', 'tbl_orderrequests_history.product_name')
            ->where('order_ref_no', $ref_id)
            ->get();
        $data['pro_customer'] = DB::table('tbl_orderrequests')
            ->select('*')
            ->join('tbl_customers', 'tbl_customers.id', '=', 'tbl_orderrequests.customer_id')
            ->where('tbl_orderrequests.order_ref_no', $ref_id)
            ->first();
        $data['total_weight'] = DB::table('tbl_orderrequests_history')
            ->where('order_ref_no', $ref_id)
            ->sum('product_weight');
        $data['refer_id'] = $ref_id;

        return view('batcher.order_details', $data);
    }

    public function production_status()
    {
        $data = array();
        $ref_array = array();


        $data['machines'] = $machines = $machine_datas = DB::table('tbl_addmachine')
            ->where('status', 1)
            ->get();

        $k = 0;
        foreach ($machine_datas as $mach) {
            $machine_datas[$k]->machine = DB::table('tbl_queue_list')
                ->select('*')
                ->join('tbl_addmachine', 'tbl_addmachine.id', '=', 'tbl_queue_list.machine_id')
                ->where('tbl_queue_list.machine_id', $mach->id)
                ->where('tbl_queue_list.status', 2)
                ->first();
            $k++;
        }
        $data['machine_datas'] = $machine_datas;
        return view('batcher.production_status', $data);
    }

    public function update_production_status(Request $request)
    {
        $order_ref_no = $request->ref_no;
        $unique_id = $request->unique_id;
        $machine_id = $request->machine_id;


        $chemberTwo = DB::table('tbl_queue_list')
            ->select('*')
            ->where('tbl_queue_list.machine_id', $machine_id)
            ->where('tbl_queue_list.status', 3)
            ->get();
        if(count($chemberTwo) < 1){
            $get_machine_id = DB::table('tbl_queue_list')
                ->where('unique_id', $unique_id)
                ->first();

            $arrData = array(
                'status' => 3
            );
            $updated = DB::table('tbl_queue_list')
                ->where('order_ref_no', $order_ref_no)
                ->where('unique_id', $unique_id)
                ->update($arrData);

            if ($updated) {
                $get_other_queue_data = DB::table('tbl_queue_list')
                    ->where('machine_id', $get_machine_id->machine_id)
                    ->where('status', 1)
                    ->orderBy('queue_no', 'asc')
                    ->get();
                $total_size = sizeof($get_other_queue_data);
                $k = 1;
                foreach ($get_other_queue_data as $get_other) {
                    $arrData = array(
                        'queue_no' => $k
                    );
                    DB::table('tbl_queue_list')
                        ->where('id', $get_other->id)
                        ->update($arrData);
                    $k++;
                }

                $all_order_no = DB::table('tbl_orderrequests_history')
                    ->where('order_ref_no', $order_ref_no)
                    ->where('unique_id', $unique_id)
                    ->get();
                foreach ($all_order_no as $item) {
                    $arrData = array(
                        'status' => 'Pending'
                    );
                    $updated = DB::table('tbl_orderrequests_history')
                        ->where('order_ref_no', $order_ref_no)
                        ->where('unique_id', $unique_id)
                        ->update($arrData);
                }

            }
            return redirect("/search-machine-queue_by_id/$machine_id");

        }
        else{
            return redirect("/search-machine-queue_by_id/$machine_id")->with('message', "Chember Two is Busy!");;
        }

    }


    public function finish_production_status(Request $request)
    {
        $order_ref_no = $request->ref_no;
        $unique_id = $request->unique_id;
        $machine_id = $request->machine_id;
        $finish_id = $request->finish_id;


            $get_machine_id = DB::table('tbl_queue_list')
                ->where('unique_id', $unique_id)
                ->first();

            $arrData = array(
                'status' => 0,
                'queue_no' => NULL
            );
            $updated = DB::table('tbl_queue_list')
                ->where('order_ref_no', $order_ref_no)
                ->where('unique_id', $unique_id)
                ->update($arrData);

            if ($updated) {
                $get_other_queue_data = DB::table('tbl_queue_list')
                    ->where('machine_id', $get_machine_id->machine_id)
                    ->where('status', 1)
                    ->orderBy('queue_no', 'asc')
                    ->get();
                $total_size = sizeof($get_other_queue_data);
                $k = 1;
                foreach ($get_other_queue_data as $get_other) {
                    $arrData = array(
                        'queue_no' => $k
                    );
                    DB::table('tbl_queue_list')
                        ->where('id', $get_other->id)
                        ->update($arrData);
                    $k++;
                }

                $all_order_no = DB::table('tbl_orderrequests_history')
                    ->where('order_ref_no', $order_ref_no)
                    ->where('unique_id', $unique_id)
                    ->get();
                foreach ($all_order_no as $item) {
                    $arrData = array(
                        'status' => 'Finish'
                    );
                    $updated = DB::table('tbl_orderrequests_history')
                        ->where('order_ref_no', $order_ref_no)
                        ->where('unique_id', $unique_id)
                        ->update($arrData);
                }
                $arrData = array(
                    'status' => 0,
                );
                $updated_troli = DB::table('tbl_troli')
                    ->where('order_ref_no', $order_ref_no)
                    ->where('unique_id', $unique_id)
                    ->update($arrData);
            }

            $data['id'] = $machine_id;

            $data['machine_datas'] = DB::table('tbl_addmachine')
                ->where('status', 1)
                ->get();

            $data['name'] = $machine_datas = DB::table('tbl_addmachine')
                ->where('id', $machine_id)
                ->where('status', 1)
                ->first();

            $data['running2'] = DB::table('tbl_queue_list')
                ->where('machine_id', $machine_id)
                ->where('status', 3)
                ->orderBy('id', 'asc')
                ->first();

        return view('batcher.packaging_status', $data);


    }




    public function production_start(Request $request)
    {
        $machine_id = $request->machine_id;
        $unique_id = $request->unique_id;


            $check = DB::table('tbl_queue_list')
                ->where('status', 2)
                ->where('machine_id', $machine_id)
                ->first();
            if (isset($check) && !empty($check)) {
                Session::flash('alert-class', 'btn-danger');
                return redirect("/search-machine-queue_by_id/$machine_id")->with('message', "Machine Busy.");
            }else{
                $check_queue = DB::table('tbl_queue_list')
                    ->where('status', 1)
                    ->where('machine_id', $machine_id)
                    ->orderBy('queue_no', 'asc')
                    ->first();
                if($check_queue->unique_id == $unique_id) {
                    $arrData = array(
                        'status' => 2
                    );
                    $update = DB::table('tbl_troli')
                        ->where('unique_id', $unique_id)
                        ->update($arrData);
                    $arr = array(
                        'status' => 2
                    );
                    $update_list = DB::table('tbl_queue_list')
                        ->where('unique_id', $unique_id)
                        ->where('machine_id', $machine_id)
                        ->update($arr);
                    $arrs = array(
                        'status' => 'Running'
                    );
                    $update_history = DB::table('tbl_orderrequests_history')
                        ->where('unique_id', $unique_id)
                        ->update($arrs);
                    return redirect("/search-machine-queue_by_id/$machine_id");
                }else{
    //                Session::flash("message', 'Unique ID Doesn't match!");
                    Session::flash('alert-class', 'btn-danger');
                    return redirect("/search-machine-queue_by_id/$machine_id")->with('message', "Unique ID Doesn't match!");
                }

            }



    }

    public function search_machine_queue(Request $request)
    {
        $data = array();

        $data['machines'] = $machine_datas = DB::table('tbl_addmachine')
            ->where('status', 1)
            ->get();

        $machine_id = $request->machine_id;
        $data['running'] = DB::table('tbl_queue_list')
            ->where('machine_id', $machine_id)
            ->where('status', 2)
            ->orderBy('id', 'asc')
            ->first();


        $data['running2'] = DB::table('tbl_queue_list')
            ->where('machine_id', $machine_id)
            ->where('status', 3)
            ->orderBy('id', 'asc')
            ->first();




        if (isset($machine_id) && !empty($machine_id)) {
            //$machine_id = $_GET['machine_id'];
            $data['id'] = $machine_id;
            $data['name'] = $machine_datas = DB::table('tbl_addmachine')
                ->where('id', $machine_id)
                ->where('status', 1)
                ->first();

            $data['queue_lists'] = DB::table('tbl_queue_list')
                ->select('*')
                ->where('tbl_queue_list.machine_id', $machine_id)
                ->where('tbl_queue_list.status', 1)
                ->orderBy('queue_no', 'asc')
                ->get();

            $data['queue_lists2'] = DB::table('tbl_queue_list')
                ->select('*')
                ->where('tbl_queue_list.machine_id', $machine_id)
                ->where('tbl_queue_list.status', 3)
                ->orderBy('queue_no', 'asc')
                ->get();

        } else {
            $data['queue_lists'] = '';
            $data['id'] = 0;
            $data['name'] = '';
        }


        return view('batcher.production_status_page', $data);

    }

    public function search_machine_queue_by_id($id)
    {
        $data = array();
        $data['machines'] = $machine_datas = DB::table('tbl_addmachine')
            ->where('status', 1)
            ->get();
        $machine_id = $id;
        if(isset($machine_id) && !empty($machine_id)) {
            //$machine_id = $_GET['machine_id'];
            $data['id'] = $machine_id;
            $data['name'] = $machine_datas = DB::table('tbl_addmachine')
                ->where('id', $machine_id)
                ->where('status', 1)
                ->first();

            $data['running'] = DB::table('tbl_queue_list')
                ->where('machine_id', $machine_id)
                ->where('status', 2)
                ->orderBy('id', 'asc')
                ->first();

            $data['running2'] = DB::table('tbl_queue_list')
                ->where('machine_id', $machine_id)
                ->where('status', 3)
                ->orderBy('id', 'asc')
                ->first();

            $data['queue_lists'] = DB::table('tbl_queue_list')
                ->select('*')
                ->where('tbl_queue_list.machine_id', $machine_id)
                ->where('tbl_queue_list.status', 1)
                ->orderBy('queue_no', 'asc')
                ->get();

            $data['queue_lists2'] = DB::table('tbl_queue_list')
                ->select('*')
                ->where('tbl_queue_list.machine_id', $machine_id)
                ->where('tbl_queue_list.status', 3)
                ->orderBy('queue_no', 'asc')
                ->get();
        } else {
            $data['queue_lists'] = '';
            $data['id'] = 0;
            $data['name'] = '';
        }


        return view('batcher.production_status_page', $data);

    }

    public function packaging_stutas_view(){
        $machine_datas = DB::table('tbl_addmachine')
            ->where('status', 1)
            ->get();
        return view('batcher.packaging_status', compact('machine_datas'));
    }



    public function packaging_stutas(Request $request){

        $machine_id = $request->machine_id;
        $data['id'] = $machine_id;

        $data['machine_datas'] = DB::table('tbl_addmachine')
            ->where('status', 1)
            ->get();

        $data['name'] = $machine_datas = DB::table('tbl_addmachine')
            ->where('id', $machine_id)
            ->where('status', 1)
            ->first();

        $data['running2'] = DB::table('tbl_queue_list')
            ->where('machine_id', $machine_id)
            ->where('status', 3)
            ->orderBy('id', 'asc')
            ->first();

        return view('batcher.packaging_status', $data);
    }


    public function packaging_stutas_by($id){

        $data['id'] = $id;

        $data['machine_datas'] = DB::table('tbl_addmachine')
            ->where('status', 1)
            ->get();

        $data['name'] = $machine_datas = DB::table('tbl_addmachine')
            ->where('id', $machine_id)
            ->where('status', 1)
            ->first();

        $data['running2'] = DB::table('tbl_queue_list')
            ->where('machine_id', $machine_id)
            ->where('status', 3)
            ->orderBy('id', 'asc')
            ->first();

        return view('batcher.packaging_status', $data);
    }





    public function ajaxRequest_mechine_data_read(Request $request)
    {
        $host    = $request->host;
        $port    = $request->port;

// create socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
        $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");

// send string to server
        //socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
// get server response

        $result = socket_read($socket, 1024) or die("Could not read server response\n");
        $result =  trim($result);
        $result =  floatval($result);

        return $result;
    }

}
