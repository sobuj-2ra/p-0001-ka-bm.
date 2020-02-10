<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_orderrequest extends Model
{
    //
    protected $fillable = [
        'customer_id',
        'order_ref_no',
        'ref_type',
        'request_date',
        'product_name',
        'product_weight',
        'machine_id',
        'queue_no',
        'status'
      ];

    public function getRefType(){
        return $this->belongsTo(ProductType::class,'ref_type');
    }

}
