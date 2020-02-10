<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    //

    protected $table = 'tbl_addmachine';
    protected $primaryKey = 'id';

    protected $fillable = [
        'machine_name',
        'remarks',
        'status'
      ];

}
