<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $primaryKey = 'slug';
    protected $keyType = 'string';
    public $fillables = ['slug','title','type','body'];
}
