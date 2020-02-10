<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbl_addproduct;
use App\tbl_barcode;
use App\tbl_stockin;
use App\tbl_orderrequest;
use App\Customer;
use App\Deleted_log;
use Session;
use Auth;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $showcustomerlastid = DB::table('tbl_customers')
        ->orderBy('id', 'desc')
        ->take(1)
        ->get();

       //print_r($showcustomerlastid);
       //exit();
        if(count($showcustomerlastid) < 1){
            $showcustomerlastid = ['id'=>0];
        }

        return view('customer.add',compact('showcustomerlastid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
          $company_name=$request->company_name;
          $count = DB::table('tbl_customers')
                       ->where('company_name', $company_name)
                       ->count();

            if($count > 0){
                Session::flash('message', 'Sorry!Alreday Compnay Name Taken');
                Session::flash('alert-class', 'btn-danger');
                return redirect('/customer');
            }else{
                $datacustomer = new Customer([
                    'company_id' => $request->company_id,
                    'company_name' => $company_name,
                    'head_phone_number' => $request->head_phone_number,
                    'status' => 1,
                ]);

                $insert=$datacustomer->save();
                if($insert){
                    Session::flash('message', 'Yes! Successfully Insert Data.');
                    Session::flash('alert-class', 'btn-success');
                    return redirect('/customer');
                }else{
                    Session::flash('message', 'Fail! Data Insert Not Successfully');
                    Session::flash('alert-class', 'btn-danger');
                    return redirect('/customer');
                }
            }
    }


    public function showcustomer(){

        $showcustomer = DB::table('tbl_customers')
            /*->leftJoin('tbl_addproducts', 'tbl_barcodes.product_id', '=', 'tbl_addproducts.id')
            ->groupBy('tbl_barcodes.print_lock') */
            ->orderBy('id', 'desc')
            ->get();

        return view('customer.showcustomer',compact('showcustomer'));
    }

    public function customer_report(){

        $showcustomer = DB::table('tbl_customers')
            /*->leftJoin('tbl_addproducts', 'tbl_barcodes.product_id', '=', 'tbl_addproducts.id')
            ->groupBy('tbl_barcodes.print_lock') */
            ->orderBy('id', 'desc')
            ->get();

        return view('customer.customer_report',compact('showcustomer'));
    }


    public function editcustomer($id){
        $data['edit_company'] =Customer::find($id);
        return view('customer.add',$data);
    }



    public function updatecustomer(Request $request){
        $id= $request->hiddenproductid;
        $editcustomer =customer::find($id);
        $editcustomer->company_id=$request->company_id;
        $editcustomer->company_name=$request->company_name;
        $editcustomer->head_contact_name=$request->head_contact_name;
        $editcustomer->head_land_phone_number=$request->head_land_phone_number;
        $editcustomer->head_phone_number=$request->head_phone_number;
        $editcustomer->head_email=$request->head_email;
        $editcustomer->head_address=$request->head_address;
        $editcustomer->factory_contact_person_name=$request->factory_contact_person_name;
        $editcustomer->factory_land_phone_number=$request->factory_land_phone_number;
        $editcustomer->factory_phone_number=$request->factory_phone_number;
        $editcustomer->factory_email=$request->factory_email;
        $editcustomer->factory_address=$request->factory_address;

        $updatecustomer=$editcustomer->save();
        if($updatecustomer){
            Session::flash('message', 'Successfully Update Data !');
            Session::flash('alert-class', 'btn-info');
            }else{
            Session::flash('message', 'Fail to Update Data !');
            Session::flash('alert-class', 'btn-danger');
            }
            return redirect('/showcustomer');
     }







    public function customerdelete($id){
        $user_id = Auth::user()->user_id;
        $curDateTime = Date('Y-m-d H:i:s');
        $oldData = Customer::find($id);
        $delData = new Deleted_log;
        $delData->delete_id = $id;
        $delData->type = 'Operation/Customar';
        $delData->delete_by = $user_id;
        $delData->delete_date = $curDateTime;
        $delData->delete_data =  "$oldData->company_name/$oldData->head_phone_number";
        $delData->save();

        $customer =Customer::find($id);
        $deletecustomer=$customer ->delete();
        if($deletecustomer){
            Session::flash('message', 'Successfully Deleted Data !');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Fail to Delete Data !');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/showcustomer');
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
