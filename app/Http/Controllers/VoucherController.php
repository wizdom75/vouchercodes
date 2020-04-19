<?php

namespace App\Http\Controllers;

use App\Voucher;
use App\Retailer;
use App\SuggestedCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{

    public function suggested()
    {
        $suggested = SuggestedCode::orderBy('id', 'desc')->paginate(10);

        return $suggested;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {
        $vouchers = Voucher::orderBy('title')->paginate(10);
        return $vouchers;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Voucher::orderBy('id', 'desc')->paginate(10);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'retailer_mid' => 'required', 
            'type' => 'required', 
            'code' => 'max:100', 
            'title' => 'max:50', 
            'blurb' => 'max:100',
            'terms' => 'max:200',
            'valid_from' => 'date',
            'valid_to' => 'date'
        ]);

        
       return Voucher::create($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        
        $data = $request->validate([
            'retailer_mid' => 'required', 
            'type' => 'required', 
            'code' => 'max:100', 
            'title' => 'max:191', 
            'blurb' => 'max:191',
            'terms' => 'max:2000',
            'url' => 'max:2000',
            'valid_from' => 'date',
            'valid_to' => 'date'
        ]);

        if($voucher->update($data)){
            return 'Update successful';
        }else{
            return 'Update failed';
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return 'Success';
    }

    /**
     * Process the uploaded file.
     */
    public function csvProcess(Request $request, $prefix)
    {

        //Handle csv upload
        if($request->hasFile('csv_file')){
            $filename_save = 'vouchercodes.csv';       
            $file = $request->file('csv_file')->storeAs('/datafeeds', $filename_save);

        }
        $handle = fopen($request->file('csv_file'), 'r');
        $i = 0;
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE){
            if($i === 0){

            }else{
                $m = Retailer::find($prefix.''.$data[0]);
                $r = Retailer::where('slug', $this->makeSlug($data[10]))->first();
                if($m || $r){
                    echo 'Duplicate record skipped';
                    continue;
                }else{

                $retailer = new Retailer;
                $retailer->mid = trim($prefix.''.$data[0]);
                $retailer->user_id = 1;
                $retailer->title = trim($data[1]);
                $retailer->meta = trim($data[1]);
                $retailer->description = trim($data[6]);
                $retailer->url = trim($data[10]);
                $retailer->tracking_url = trim($data[7]);
                $retailer->slug = $this->makeSlug($data[10]);
                $retailer->logo = trim($data[2]);
                $retailer->save();
                }
            }
            $i++;
        }
        fclose($handle);
    }

    public function makeSlug($url)
    {
        $parse = parse_url($url);
        $domain = str_replace("www.", "", $parse['host']);
        return $domain;

    }

    public function getRetailerOffers($mid)
    {    
        $offer = DB::table('vouchers')->where('retailer_mid', $mid)->where('valid_to', '<', 'CURDATE()')->get();
        return json_encode($offer);
    }

    public function getCategoryOffers($slug)
    {
        $offers = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store')->where('vouchers.valid_to', '>=', 'CURDATE()')->where('category_slug', 'LIKE', '%'.$slug.'%')->get();
        $category = DB::table('categories')->select('title')->where('slug', $slug)->first();
        return json_encode([$offers, $category]);
    }
    public function getStudentOffers()
    {
        $offers = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store')->where('vouchers.valid_to', '>=', 'CURDATE()')->where('description', 'LIKE', '%school%')->get();
        return json_encode($offers);
    }
    public function getNHSOffers()
    {
        $offers = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store')->where('vouchers.valid_to', '>=', 'CURDATE()')->where('category_slug', 'LIKE', '%health%')->get();
        return json_encode($offers);
    }
    public function getExclusiveOffers()
    {
        $offers = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store')->where('vouchers.valid_to', '>=', 'CURDATE()')->where('category_slug', 'LIKE', '%christmas%')->get();
        return json_encode($offers);
    }
    public function getFeaturedOffers($slug)
    {
        $offers = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store')->where('vouchers.valid_to', '>=', 'CURDATE()')->where('category_slug', 'LIKE', '%'.$slug.'%')->get();
        return json_encode($offers);
    }
    public function getResturantOffers()
    {
        $offers = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store')->where('vouchers.valid_to', '>=', 'CURDATE()')->where('category_slug', 'LIKE', '%food%')->get();
        return json_encode($offers);
    }
    public function getTop20Offers()
    {
        // $offers = DB::table('vouchers')
        // ->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')
        // ->join('clicks', 'clicks.voucher_id', '=', 'vouchers.id')
        // ->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', \DB::raw('COUNT(clicks.id) as clicks'))
        // ->orderBy('clicks', 'DESC')
        // ->limit(20)
        // ->get();

        $offers = DB::table('clicks')
        ->join('vouchers', 'vouchers.id', '=', 'clicks.voucher_id')
        ->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')
        ->select('vouchers.*', 'retailers.logo', 'retailers.title AS store')
        ->where('type', '=', ['voucher', 'code'])
        ->groupBy('clicks.voucher_id')
        ->limit(20)
        ->get();
        return json_encode($offers);
    }
    public function featuredOffers()
    {
        $top20 = DB::table('clicks')
        ->join('vouchers', 'vouchers.id', '=', 'clicks.voucher_id')
        ->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')
        ->leftJoin('retailer_banners', 'retailer_banners.retailer_mid', '=', 'vouchers.retailer_mid')
        ->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug', 'retailer_banners.banner')
        ->where('vouchers.valid_to', '>=', 'CURDATE()')
        ->where('type', '=', ['voucher', 'code'])
        ->groupBy('clicks.voucher_id')
        ->limit(6)
        ->get();
        $featured1 = DB::table('vouchers')
        ->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')
        ->leftJoin('retailer_banners', 'retailer_banners.retailer_mid', '=', 'vouchers.retailer_mid')
        ->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug', 'retailer_banners.banner')
        ->where('vouchers.valid_to', '>=', 'CURDATE()')
        ->where('vouchers.title', 'LIKE', ['%beauty%', '%perfume%'])
        ->orWhere('vouchers.category_slug', 'LIKE', ['%beauty%', '%perfume%'])
        ->limit(6)
        ->groupBy('vouchers.id')
        ->get();
        // $featured1 = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug')->where('vouchers.title', 'LIKE', '%beauty%')->limit(6)->get();
        $featured2 = DB::table('vouchers')
        ->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')
        ->leftJoin('retailer_banners', 'retailer_banners.retailer_mid', '=', 'vouchers.retailer_mid')
        ->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug', 'retailer_banners.banner')
        ->where('vouchers.valid_to', '>=', 'CURDATE()')
        ->where('vouchers.title', 'LIKE', ['%fashion%', '%cloth%'])
        ->orWhere('vouchers.category_slug', 'LIKE', ['%fashion%', '%cloth%'])
        ->limit(4)
        ->groupBy('vouchers.id')
        ->get();
        //$featured2 = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug')->where('vouchers.title', 'LIKE', '%fashion%')->limit(4)->get();
        $featured3 = DB::table('vouchers')
        ->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')
        ->leftJoin('retailer_banners', 'retailer_banners.retailer_mid', '=', 'vouchers.retailer_mid')
        ->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug', 'retailer_banners.banner')
        ->where('vouchers.valid_to', '>=', 'CURDATE()')
        ->where('vouchers.title', 'LIKE', ['%holiday%', '%travel%'])
        ->orWhere('vouchers.category_slug', 'LIKE', ['%travel%', '%airport%'])
        ->limit(4)
        ->groupBy('vouchers.id')
        ->get();
        // $featured3 = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug')->where('vouchers.title', 'LIKE', '%travel%')->limit(4)->get();
        $featured4 = DB::table('vouchers')
        ->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')
        ->leftJoin('retailer_banners', 'retailer_banners.retailer_mid', '=', 'vouchers.retailer_mid')
        ->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug', 'retailer_banners.banner')
        ->where('vouchers.valid_to', '>=', 'CURDATE()')
        ->where('vouchers.title', 'LIKE', ['%tech%', '%phone%'])
        ->orWhere('vouchers.category_slug', 'LIKE', ['%tech%', '%gadget%'])
        ->limit(4)
        ->groupBy('vouchers.id')
        ->get();
        // $featured4 = DB::table('vouchers')->join('retailers', 'vouchers.retailer_mid', '=', 'retailers.mid')->select('vouchers.*', 'retailers.logo', 'retailers.title AS store', 'retailers.slug')->where('vouchers.title', 'LIKE', '%friday%')->limit(4)->get();
        $offers = [$top20, $featured1,$featured2,$featured3,$featured4];
        return json_encode($offers);
    }
}
