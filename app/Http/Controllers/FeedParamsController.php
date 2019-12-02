<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FeedSetting;

class FeedParamsController extends Controller
{
   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feedSettings = new FeedSetting;
        foreach($request->columns as $key => $value){
            if(isset($value)){
                switch ($value) {
                    case 'retailer_mid_col':
                        $feedSettings->retailer_mid_col = $key;
                        break;
                    case 'type_col':
                        $feedSettings->type_col = $key;
                        break;
                    case 'code_col':
                        $feedSettings->code_col = $key;
                        break;
                    case 'title_col':
                        $feedSettings->title_col = $key;
                        break;
                    case 'blurb_col':
                        $feedSettings->blurb_col = $key;
                        break;
                    case 'terms_col':
                        $feedSettings->terms_col = $key;
                        break;
                    case 'url_col':
                        $feedSettings->url_col = $key;
                        break;
                    case 'valid_from_col':
                        $feedSettings->valid_from_col = $key;
                        break;
                    case 'valid_to_col':
                        $feedSettings->valid_to_col = $key;
                        break;
                    case 'category_slug_col':
                        $feedSettings->category_slug_col = $key;
                        break;
                    case 'promo_id_col':
                        $feedSettings->promo_col = $key;
                        break;
                }
            }
        }
        $feedSettings->feed_id = $request->feed_id;

        $feedSettings->save();

        return $feedSettings;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $feedSettings = FeedSetting::find($id);
        foreach($request->columns as $key => $value){
            if(isset($value)){
                switch ($value) {
                    case 'retailer_mid_col':
                        $feedSettings->retailer_mid_col = $key;
                        break;
                    case 'type_col':
                        $feedSettings->type_col = $key;
                        break;
                    case 'code_col':
                        $feedSettings->code_col = $key;
                        break;
                    case 'title_col':
                        $feedSettings->title_col = $key;
                        break;
                    case 'blurb_col':
                        $feedSettings->blurb_col = $key;
                        break;
                    case 'terms_col':
                        $feedSettings->terms_col = $key;
                        break;
                    case 'url_col':
                        $feedSettings->url_col = $key;
                        break;
                    case 'valid_from_col':
                        $feedSettings->valid_from_col = $key;
                        break;
                    case 'valid_to_col':
                        $feedSettings->valid_to_col = $key;
                        break;
                    case 'category_slug_col':
                        $feedSettings->category_slug_col = $key;
                        break;
                    case 'promo_id':
                        $feedSettings->promo_id = $key;
                        break;
                }
            }
        }
        $feedSettings->feed_id = $request->feed_id;

        $feedSettings->save();

        return $feedSettings;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedSettings = FeedSetting::find($id);
        $feedSettings->delete();

        return $feedSettings;
    }
}
