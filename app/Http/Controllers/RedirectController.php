<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Click;
use App\Retailer;
use App\Voucher;

class RedirectController extends Controller
{
    /**
     * Redirect method and tracking clicks
     */
    public function go($mid, $id)
    {
        if($id > 0){
            $voucher = Voucher::find($id);
            $redirect = $voucher->url;
            $click = new Click;
            $click->voucher_id = $id;
            $click->ip = \Request::ip();
    
            $click->save();
            return redirect($redirect);
        }else{
            $retailer = Retailer::find($mid);
            $redirect = $retailer->tracking_url;
            $click = new Click;
            $click->ip = \Request::ip();
            $click->merchant_id = $mid;

            $click->save();
            return redirect($redirect);
        }
    }
}
