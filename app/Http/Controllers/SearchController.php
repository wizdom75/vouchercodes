<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function liveSearch($term)
    {
        $offers = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug')->where('retailers.title', 'LIKE', '%'.$term.'%')->get();
        
        $stores = DB::table('retailers')->select('*')->where('title', 'LIKE', '%'.$term.'%')->get();
        
        $categories = DB::table('categories')->select('*')->where('title', 'LIKE', '%'.$term.'%')->get();
        $data = [$offers, $stores, $categories];
        return json_encode($data);
    }
}
