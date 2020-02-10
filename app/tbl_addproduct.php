<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductType;

class tbl_addproduct extends Model
{
    //

    protected $fillable = [
        'product_name',
        'product_type',
        'product_code',
        'product_barcode'
      ];


    public function getProducyType(){
        return $this->belongsTo(ProductType::class,'product_type');
    }


}
