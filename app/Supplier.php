<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Supplier extends Model
{
    //

     protected $table = 'suppliers';

     protected $fillable = [
        'supplier_name',
        'phone_number',
        'email',
        'address_line',
        'city',
        'country_of_origin',
        'postcode',
        'country',
        'status'
      ];
}
