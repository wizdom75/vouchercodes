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
    public function go($id)
    {
        if(is_numeric($id)){
            $voucher = Voucher::find($id);
            $redirect = $voucher->url;
        }else{
            $retailer = Retailer::find($id);
            $redirect = $retailer->tracking_url;
        }
        

        $click = new Click;

        $click->ip = \Request::ip();

        $click->save();

        return redirect($redirect);
    }
}
