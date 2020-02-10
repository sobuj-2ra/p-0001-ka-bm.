<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductType;

class Formula extends Model
{
    //

    protected $table = 'tbl_addformula';
    protected $primaryKey = 'id';

    protected $fillable = [
        'formula_name',
        'f_type',
        'product_name',
        'product_weight',
        'unit_name',
        'status'
      ];

    public function getFormulaType(){
        return $this->belongsTo(ProductType::class,'f_type');
    }

    public function getProductName(){
        return $this->belongsTo(tbl_addproduct::class,'product_name');
    }


}
