<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    public $fillable = ['retailer_mid', 'promo_id', 'category_slug', 'type', 'code', 'title','blurb','terms','url','valid_from','valid_to'];
}
