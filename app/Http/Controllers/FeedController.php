<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feed;
use App\FeedSetting;
use App\Voucher;

use ZipArchive;

class FeedController extends Controller
{
    public function index()
    {
        return Feed::paginate(10);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'affiliate' => 'required', 
            'url' => 'required', 
            'compression' => 'max:100', 
        ]);
        $feed = new Feed;
        $feed->affiliate = $request->input('affiliate');
        $feed->url = $request->input('url');
        $feed->compression = $request->input('compression');

        $feed->save();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'affiliate' => 'required', 
            'url' => 'required', 
            'compression' => 'max:100', 
        ]);

        $feed = Feed::find($id);

        $feed->affiliate = $request->input('affiliate');
        $feed->url = $request->input('url');
        $feed->compression = $request->input('compression');

        if($feed->update()){
            return 'Update successful';
        }else{
            return 'Update failed';
        }
    }

    public function destroy($id)
    {
        $feed = Feed::find($id);

        $feed->delete();

        return 'Success';
    }

    /**
     * Test run method to set the feed parameters
     */
    public function test($id)
    {
        $feed = Feed::find($id);
        $affiliate = $feed->affiliate;
        $url = $feed->url;
        $compression = $feed->compression;

        
        $dest = 'storage/autofeeds/'.$affiliate;
        if(!is_dir($dest)){
            mkdir($dest, 0777, $url);
        }

        $this->getRemoteFile($url, $dest.'/testrun.csv');
        copy($url, $dest.'/testrun.csv');
        $fname = 'testrun.csv';
        
        $zip = new ZipArchive;
        if ($zip->open($dest.'/testrun.csv') === TRUE) {
            $zip->renameName($zip->getNameIndex(0), $fname);
            $zip->extractTo($dest, $fname);
            $zip->close();
            unlink($dest.'/testrun.csv');
        }

        $handle = fopen($dest.'/'.$fname, 'r');
        $i = 0;
        while (($data = fgetcsv($handle, 0, ',')) !== FALSE){
            $params[] = $data;
            // count($data) is the number of columns
            $numcols = count($data);
            if ($i< 5) {
                continue;
            }
           
            $i++;
        }
        //print_r($params);
        //die;
        return $params;
    }

    /**
     * Rest post route that creates the settings form
     */
    public function testCreate(Request $request, $id)
    {
        $feed = Datafeed::find($id);

        foreach($request->params as $key => $value){
            if(isset($value)){
                switch ($value) {
                    case 'voucherName':
                        $feed->column_name = $key;
                        break;
                    case 'voucherDesc':
                        $feed->column_description = $key;
                        break;
                    case 'voucherPrice':
                        $feed->column_price = $key;
                        break;
                    case 'categoryName':
                        $feed->column_category_name = $key;
                        break;
                    case 'categoryId':
                        $feed->column_category_id = $key;
                        break;
                    case 'shipping':
                        $feed->column_shipping = $key;
                        break;
                    case 'buyUrl':
                        $feed->column_buy_url = $key;
                        break;
                    case 'promoText':
                        $feed->column_promo = $key;
                        break;
                    case 'mpn':
                        $feed->column_mpn = $key;
                        break;
                    case 'upc':
                        $feed->column_upc = $key;
                        break;
                    case 'isbn':
                        $feed->column_isbn = $key;
                        break;
                    case 'ean':
                        $feed->column_ean = $key;
                        break;
                    case 'image':
                        $feed->column_image_url = $key;
                        break;
                    case 'brand':
                        $feed->column_brand = $key;
                        break;
                }
            }
        }
        $feed->add_new_vouchers = $request->add_new_vouchers;
        $feed->match_by = $request->match_by;
        $feed->save();
        return redirect('/admin/datafeeds')->with('success', 'Datafeed Parameters Added Successfully!');
    }

    /**
     * Run the datafeed to update prices
     */
    public function run($id)
    {
        $feed = Feed::find($id);
        $feedSettings = FeedSetting::where('feed_id', $id)->first();

        /**
         * Affiliate prefix is set here
         */
        $affiliate = $feed->affiliate;

        /**
         * feed url is set here
         */
        $url = $feed->url;

        /**
         * Now we create the merchant autofeed
         * folder if it does not exist
         */
        $feedFolder = 'storage/autofeeds/'.$affiliate;
        if(!is_dir($feedFolder)){
            mkdir($feedFolder, 0777, $url);
        }

        $fname = 'voucherfeed.csv';
        /**
         * Download the latest datafeed from merchant 
         * and copy to our newly created folder / server
         */
        $this->getRemoteFile($url, $feedFolder.'/'.$fname);
        copy($url, $feedFolder.'/'.$fname);
 

        $file = $feedFolder.'/'.$fname;

        $handle = fopen($file, 'r');
        /**
         * Initiate counter that is used to skip hearders
         */
        $i = 0;

        /**
         * Now process the file
         */
        while (($data = fgetcsv($handle, 0, ',')) !== FALSE){
            if($i === 0){
                //Skip headers in CSV file
            }else{ 
                //Skip voucher if it is already in database
                if(Voucher::where('promo_id', $data[$feedSettings->promo_id_col])->first()){
                    continue;
                }
                $valid_from = date('Y-m-d H:i:s', strtotime(str_replace('-', '/',  $data[$feedSettings->valid_from_col])));
                $voucher = new Voucher;                        
                $voucher->retailer_mid = $affiliate.$data[$feedSettings->retailer_mid_col];
                $voucher->type = $data[$feedSettings->type_col];
                $voucher->code = $data[$feedSettings->code_col];
                $voucher->title = substr($data[$feedSettings->title_col], 0,190);
                $voucher->blurb = $data[$feedSettings->blurb_col];
                $voucher->terms = $data[$feedSettings->terms_col];
                $voucher->url = $data[$feedSettings->url_col];
                $voucher->valid_from = ($valid_from == '1970-01-01 00:00:00')?'1970-01-01 00:00:10':$valid_from;
                $voucher->valid_to = date('Y-m-d H:i:s', strtotime(str_replace('-', '/',  $data[$feedSettings->valid_to_col])));
                $voucher->category_slug = $data[$feedSettings->category_slug_col];
                $voucher->promo_id = $data[$feedSettings->promo_id_col];
                $voucher->save();
            }

            $i++;//Counter used to skip csv file headers
        }
        fclose($handle);

        return 'Vocuher feed ran successfully';
    }
    /**
     * get remote file
     */
    private function getRemoteFile($source, $destination)
    {
        set_time_limit(0);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec ($ch);
        curl_close ($ch);

        $file = fopen($destination, "w+");
        fputs($file, $data);
        fclose($file);
    }
    public function makeSlug($string)
    {
        $string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
        $string = preg_replace("/(\W)+/", "-", $string);

        $string = strtolower($string);
        
        return $string;

    }
}
