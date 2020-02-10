<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbl_addproduct;
use App\tbl_barcode;
use App\tbl_stockin;
use App\Customer;
use App\Formula;
use App\Machine;
use App\Stockout;
use App\Deleted_log;
use Auth;
use Session;
use Carbon\Carbon;

class MachineController extends Controller
{
    //

    public function addmachine()
    {
       return view('machine.addmachine');
    }



    public function storemachine(Request $request){

        $machine_name=$request->machine_name;
        $remarks=$request->remarks;


        $addmachine = new Machine([
            'machine_name' => $machine_name,
            'remarks'=> $remarks,
            'status'=> 1,
          ]);
          $inserted=$addmachine->save();

            if ($inserted){
            Session::flash('message', 'Successfully Data Insert!');
            Session::flash('alert-class', 'btn-success');
            }else{
            Session::flash('message', 'Data Insert Not Successfully!');
            Session::flash('alert-class', 'btn-danger');
            }

            return redirect('/addmachine');





     }




     public function viewmachine(){
        //$data['show_formula']=Formula::all()->sortByDesc("id");


         $show_machine = DB::table('tbl_addmachine')
        ->orderBy('id', 'desc')
        ->get();
         return view('machine.viewmachine',compact('show_machine'));
     }



    public function editmachine($id){
      $data['edit_product'] =Machine::find($id);
      return view('machine.addmachine',$data);
   }




   public function updatemachine(Request $request){
    $id= $request->hiddenproductid;
    $editmachine =Machine::find($id);
    $editmachine->machine_name=$request->machine_name;
    $editmachine->remarks=$request->remarks;

        $updateproduct=$editmachine->save();
        if ($updateproduct){
            Session::flash('message', 'Successfully Update Data !');
            Session::flash('alert-class', 'btn-info');
            }else{
            Session::flash('message', 'Fail to Update Data !');
            Session::flash('alert-class', 'btn-danger');
            }
            return redirect('/viewmachine');
    }



    public function machinedelete($id){
        $user_id = Auth::user()->user_id;
        $curDateTime = Date('Y-m-d H:i:s');
        $oldData = Machine::find($id);
        $delData = new Deleted_log;
        $delData->delete_id = $id;
        $delData->type = 'Operation/Weight Machine';
        $delData->delete_by = $user_id;
        $delData->delete_date = $curDateTime;
        $delData->delete_data =  "$oldData->machine_name/$oldData->remarks";
        $delData->save();

        $machine =Machine::find($id);
        $deletemachine=$machine ->delete();
        if ($deletemachine){
            Session::flash('message', 'Successfully Deleted Data !');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Fail to Delete Data !');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/viewmachine');
     }









}
