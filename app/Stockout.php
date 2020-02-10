<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stockout extends Model
{
    //
    protected $table = 'tbl_stockouts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'barcode',
        'product_id',
        'product_qty',
        'order_ref_no',
        'product_weight',
        'user_by',
        'status'
      ];

}
