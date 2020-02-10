<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'tbl_customers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'company_name',
        'head_contact_name',
        'head_land_phone_number',
        'head_phone_number',
        'head_email',
        'head_address',
        'factory_contact_person_name',
        'factory_land_phone_number',
        'factory_phone_number',
        'factory_email',
        'factory_address',
        'status'
      ];
}
