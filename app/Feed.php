<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public $fillables = ['affiliate', 'url', 'compression'];
}
