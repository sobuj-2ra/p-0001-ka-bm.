<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deleted_log extends Model
{
    protected $table = 'tbl_delete_log';
    public $guarded = [];
    public $timestamps = false;
}
