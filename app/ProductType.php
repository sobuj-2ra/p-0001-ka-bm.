<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\WeightMachine;

class ProductType extends Model
{
    public $table = 'product_type';

    public function getProductName(){
        return $this->hasMany(tbl_addproduct::class,'id');
    }

    public function getMachineName(){
        return $this->belongsTo(WeightMachine::class,'machine_id');
    }
}
