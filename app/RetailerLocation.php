<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerLocation extends Model
{
    public $fillable = ['retailer_mid','address_1','address_2','city','county','post_code','telephone'];
}
