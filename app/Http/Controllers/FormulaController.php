<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbl_addproduct;
use App\tbl_barcode;
use App\tbl_stockin;
use App\Customer;
use App\Formula;
use App\Stockout;
use App\tbl_orderrequest;
use App\ProductType;
use App\Deleted_log;
use Session;
use Auth;
use Carbon\Carbon;
use validation;

class FormulaController extends Controller
{
    //

    public function addformula()
    {
       $show_product=tbl_addproduct::all()->sortByDesc("id");
       //$customer=Customer::all()->sortByDesc("id");
        $product_types = ProductType::pluck('product_type','id');
        return view('formula.addformula',compact(['show_product','product_types']));
    }


    public function filterAddformula(Request $request)
    {
        $f_type =  $request->filter_formula_type;
        $product_types = ProductType::pluck('product_type','id');
        $show_product = tbl_addproduct::where('product_type',$f_type)->get();
        return view('formula.addformula',compact(['show_product','product_types','f_type']));
    }



    public function store_formula(Request $request)
    {
        $checkproduct = $request->product_name;


        $dbl_name  = Formula::where('formula_name',$request->formula_name)->get();
        if(count($dbl_name) > 0){
            Session::flash('message', 'Sorry! Product Name is Already Taken');
            Session::flash('alert-class', 'btn-danger');
            return redirect('/addformula');
            die;
        }

            if ($checkproduct != null) {
                //echo "yes data";
                $formula_name = $request->formula_name;
                $formulaType = $request->formula_type;

                $count = DB::table('tbl_addformula')->where('formula_name', $formula_name)
                    ->count();
                if ($count > 0) {
                    Session::flash('message', 'Sorry!This Formula Name Alreday Taken');
                    Session::flash('alert-class', 'btn-danger');
                    return redirect('/addformula');
                } else {



                    $historyarray = array();
                    for ($i = 0; $i < count($checkproduct); $i++) {
                        $historyarray[] = array(
                            'formula_name' => $formula_name,
                            'f_type' => $formulaType,
                            'product_name' => $request->product_name[$i],
                            'product_weight' => $request->product_weight[$i],
                            'unit_name' => $request->unit_name[$i],
                            'status' => 1,
                        );
                    }
                    $insert = DB::table('tbl_addformula')->insert($historyarray);

                    if ($insert) {
                        Session::flash('message', 'Yes! Successfully Insert Data.');
                        Session::flash('alert-class', 'btn-success');
                        return redirect('/addformula');
                    } else {
                        Session::flash('message', 'Fail! Data Insert Not Successfully');
                        Session::flash('alert-class', 'btn-danger');
                        return redirect('/addformula');
                    }
                }
            }
            else
            {
                Session::flash('message', 'Sorry! Please Add Product Name And Product weight');
                Session::flash('alert-class', 'btn-danger');
                return redirect('/addformula');
            }

     }




     public function viewformula(){
        //$data['show_formula']=Formula::all()->sortByDesc("id");


         $show_formula = Formula::orderBy('id', 'desc')
        ->select('formula_name','f_type' , DB::raw('count(product_name) as total_product'),DB::raw('sum(product_weight) as total_weight'))
        ->groupBy('formula_name')
        ->get();
         $filter_formulas = ProductType::orderby('id','desc')->pluck('product_type','id');
         return view('formula.viewformula',compact('show_formula','filter_formulas'));
     }

     public function filterformulaview(Request $request){
         $formula_type =  $request->filter_formula_type;
         $show_formula = Formula::orderBy('id', 'desc')
             ->select('formula_name','f_type' , DB::raw('count(product_name) as total_product'),DB::raw('sum(product_weight) as total_weight'))
             ->where('formula_name',$formula_type)
             ->groupBy('formula_name')
             ->get();

     }



     public function editformula($name){


         $formulas = Formula::where('formula_name',$name)->get();

         $show_product=tbl_addproduct::all()->sortByDesc("id");
         //$customer=Customer::all()->sortByDesc("id");
         $product_types = ProductType::pluck('product_type','id');

         return view('formula.editformula',compact(['show_product','formulas']));


     }

     public function deleteformula($name){
      
         $user_id = Auth::user()->user_id;
         $curDateTime = Date('Y-m-d H:i:s');
         $delData = new Deleted_log;
         $delData->delete_id = null;
         $delData->type = 'Operation/formula';
         $delData->delete_by = $user_id;
         $delData->delete_date = $curDateTime;
         $delData->delete_data =  "$name";
         $delData->save();


         $formulas = Formula::where('formula_name',$name)->get();


         foreach ($formulas as $formula){

             $formula->delete();
         }

         $formulas = Formula::where('formula_name',$name)->get();

         if(count($formulas) < 1){
             Session::flash('message', 'Yes! Successfully Delete Data.');
             Session::flash('alert-class', 'btn-success');
             return redirect('/viewformula');
         }
     }









}
