<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_barcode extends Model
{
    //
    protected $fillable = [
        'barcode',
        'product_id',
        'product_qty',
        'product_weight',
        'print_lock',
        'status'
      ];


}
