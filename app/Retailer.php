<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $primaryKey = 'mid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $fillable = ['mid', 'slug', 'user_id', 'title', 'meta', 'description','logo'];
}
