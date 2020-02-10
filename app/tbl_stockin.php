<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_stockin extends Model
{
    public $table = 'tbl_stockins';

    protected $fillable = [
        'barcode',
        'product_id',
        'product_qty',
        'product_weight',
        'status'
      ];


    public function getProduct(){
        return $this->belongsTo(tbl_addproduct::class,'product_id');
    }

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];



}
