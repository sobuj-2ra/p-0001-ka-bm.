<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fail_stockout extends Model
{
    protected $table = 'fail_stockout';
    public $guarded = [];
    public $timestamps = false;
}
