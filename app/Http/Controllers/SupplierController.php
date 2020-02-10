<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbl_addproduct;
use App\tbl_barcode;
use App\tbl_stockin;
use App\Stockout;
use App\tbl_orderrequest;
use App\Supplier;
use Auth;
use App\Deleted_log;
use Session;
use Carbon\Carbon;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('supplier.addsupplier');
    }



    public function storesupplier(Request $request){


        $supplier_name=$request->get('supplier_name');
        $phone_number=$request->get('phone_number');
        $email=$request->get('email');
        $address_line=$request->get('address_line');
        $city=$request->get('city');
        $country_of_origin=$request->get('country_of_origin');
        $postcode=$request->get('postcode');
        $country=$request->get('country');

        $addsupplier = new supplier([
           'supplier_name' => $supplier_name,
           'phone_number'=> $phone_number,
           'email'=> $email,
           'address_line'=> $address_line,
           'city'=> $city,
           'country_of_origin'=> $country_of_origin,
           'postcode'=> $postcode,
           'country'=> $country,
           'status'=> 1,
         ]);

           //echo "no";
           //DB::table('teammembersall')->insert($data);
        $inserted=$addsupplier->save();
        if ($inserted){
        Session::flash('message', 'Successfully Added Data !');
        Session::flash('alert-class', 'btn-success');
        }else{
        Session::flash('message', 'Fail to Added Data !');
        Session::flash('alert-class', 'btn-danger');
        }

        return redirect('/supplier');



       }


     public function viewsupplier(){
        $data['show_supplier']=supplier::all()->sortByDesc("id");
        return view('supplier.viewsupplier',$data);
     }



    public function editsupplier($id){
        $data['edit_product'] =supplier::find($id);
        return view('supplier.addsupplier',$data);
    }



    public function updatesupplier(Request $request){
        $id= $request->hiddenproductid;
        $editsupplier =supplier::find($id);
        $editsupplier->supplier_name=$request->supplier_name;
        $editsupplier->phone_number=$request->phone_number;
        $editsupplier->email=$request->email;
        $editsupplier->address_line=$request->address_line;
        $editsupplier->city=$request->city;
        $editsupplier->country_of_origin=$request->country_of_origin;
        $editsupplier->postcode=$request->postcode;
        $editsupplier->country=$request->country;

        $updateproduct=$editsupplier->save();
        if ($updateproduct){
            Session::flash('message', 'Successfully Update Data !');
            Session::flash('alert-class', 'btn-info');
            }else{
            Session::flash('message', 'Fail to Update Data !');
            Session::flash('alert-class', 'btn-danger');
            }
            return redirect('/viewsupplier');
    }


    public function supplierdelete($id){
        $user_id = Auth::user()->user_id;
        $curDateTime = Date('Y-m-d H:i:s');
        $oldData =supplier::find($id);
        $delData = new Deleted_log;
        $delData->delete_id = $id;
        $delData->type = 'Operation/Supplier';
        $delData->delete_by = $user_id;
        $delData->delete_date = $curDateTime;
        $delData->delete_data =  "$oldData->supplier_name/$oldData->phone_number";
        $delData->save();
        $supplier =supplier::find($id);
        $deletesupplier=$supplier ->delete();
        if ($deletesupplier){
            Session::flash('message', 'Successfully Deleted Data !');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Fail to Delete Data !');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/viewsupplier');
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
