<?php

namespace App\Http\Controllers;

use App\ProductType;
use App\WeightMachine;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Deleted_log;

class ProductTypeController extends Controller
{
    public function add_product_type(){
        $weight_machines = WeightMachine::pluck('machine_name','id');
        return view('product_type.add_product_type',compact('weight_machines'));
    }
    public function store_product_type(Request $request){

        $request->validate([
            'product_type_name'=> 'required'
        ]);
        $product_type = new ProductType();
        $product_type->product_type = $request->product_type_name;
        $product_type->machine_id = $request->weight_machine;
        $is_save  = $product_type->save();
        if ($is_save){
            Session::flash('message', 'Successfully Data Insert!');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Data Insert Not Successfully!');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/producttype/add');
    }

    public function view_product_type(){
        $all_product_type = ProductType::orderby('id','decs')->get();
        return view('product_type.view_product_type', compact('all_product_type'));
    }

    public function edit_product_type($id){
        $edit_product_types = ProductType::where('id',$id)->first();
        $weight_machines = WeightMachine::pluck('machine_name','id');
        return view('product_type.edit_product_type', compact('edit_product_types','weight_machines'));

    }

    public function update_product_type(Request $request){

        $id = $request->product_type_id;
        $product_type = ProductType::find($id);
        $product_type->product_type = $request->product_type_name;
        $product_type->machine_id = $request->weight_machine;
        $is_update  = $product_type->update();
        if ($is_update){
            Session::flash('message', 'Successfully Data Update!');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Data Update Not Successfully!');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/producttype/view');
    }

    public function delete_product_type($id){
      $user_id = Auth::user()->user_id;
      $curDateTime = Date('Y-m-d H:i:s');
      $oldData = ProductType::find($id);
      $delData = new Deleted_log;
      $delData->delete_id = $id;
      $delData->type = 'Operation/Product Type';
      $delData->delete_by = $user_id;
      $delData->delete_date = $curDateTime;
      $delData->delete_data =  "$oldData->product_type/$oldData->machine_id";
      $delData->save();


        $product_type = ProductType::find($id);
        $is_delete = $product_type->delete();
        if ($is_delete){
            Session::flash('message', 'Successfully Data Delete!');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Data Delete Not Successfully!');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/producttype/view');

    }



}
