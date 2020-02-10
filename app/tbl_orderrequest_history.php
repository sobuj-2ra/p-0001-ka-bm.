<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_orderrequest_history extends Model
{
    public $table = 'tbl_orderrequests_history';
    public $timestamps = true;

    public function getRefType(){
        return $this->hasOne(ProductType::class,'ref_type');
    }

}
