<?php

namespace App\Http\Controllers;

use App\WeightMachine;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Deleted_log;

class WeightMachineController extends Controller
{
    public function add_weight_machine(){
        return view('weight_machine.add_weight_machine');
    }
    public function store_weight_machine(Request $request){

        $request->validate([
            'weight_machine_name'=> 'required',
            'weight_machine_host'=> 'required',
            'weight_machine_port'=> 'required'
        ]);
        $mechine = new WeightMachine();
        $mechine->machine_name = $request->weight_machine_name;
        $mechine->machine_host = $request->weight_machine_host;
        $mechine->machine_port = $request->weight_machine_port;
        $is_save  = $mechine->save();
        if ($is_save){
            Session::flash('message', 'Successfully Data Insert!');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Data Insert Not Successfully!');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/weightmachine/add');
    }
    public function view_weight_machine(){
        $all_machine = WeightMachine::orderby('id','decs')->get();
        return view('weight_machine.view_weight_machine', compact('all_machine'));
    }

    public function edit_weight_machine($id){
        $edit_machines = WeightMachine::where('id',$id)->first();

        return view('weight_machine.edit_weight_machine', compact('edit_machines'));

    }

    public function update_weight_machine(Request $request){

        $id = $request->weight_machine_id;
        $mechine = WeightMachine::find($id);
        $mechine->machine_name = $request->weight_machine_name;
        $mechine->machine_host = $request->weight_machine_host;
        $mechine->machine_port = $request->weight_machine_port;
        $is_save  = $mechine->update();
        if ($is_save){
            Session::flash('message', 'Successfully Data Update!');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Data Update Not Successfully!');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/weightmachine/view');
    }

    public function delete_weight_machine($id){
        $user_id = Auth::user()->user_id;
        $curDateTime = Date('Y-m-d H:i:s');
        $oldData = WeightMachine::find($id);
        $delData = new Deleted_log;
        $delData->delete_id = $id;
        $delData->type = 'Operation/Weight Machine';
        $delData->delete_by = $user_id;
        $delData->delete_date = $curDateTime;
        $delData->delete_data =  "$oldData->machine_name".'/'."$oldData->machine_host";
        $delData->save();
        $machine = WeightMachine::find($id);
        $is_delete = $machine->delete();
        if ($is_delete){
            Session::flash('message', 'Successfully Data Delete!');
            Session::flash('alert-class', 'btn-success');
        }else{
            Session::flash('message', 'Data Delete Not Successfully!');
            Session::flash('alert-class', 'btn-danger');
        }
        return redirect('/weightmachine/view');

    }




}
