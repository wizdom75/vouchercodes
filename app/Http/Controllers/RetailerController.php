<?php

namespace App\Http\Controllers;

use App\Retailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RetailerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searched()
    {
        $retailers = DB::table('retailers')->inRandomOrder()->take(15)->get();
        return $retailers;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function popularShops($slug)
    {
        $retailers = DB::table('retailers')->where('description', 'LIKE', '%'.$slug.'%')->inRandomOrder()->take(20)->get();
        return $retailers;
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retailers = DB::table('retailers')->orderBy('title')->paginate(10);
        return json_encode($retailers); 
    } 
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {
        $retailers = DB::table('retailers')->orderBy('title')->get();
        return json_encode($retailers); 
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $retailer = DB::table('retailers')->where('slug', $slug)->first();
        return json_encode($retailer);
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByChar($char)
    {
        if($char === 'all'){
            $retailers = DB::table('retailers')->orderBy('title')->get();
        }elseif($char === 'num'){
            $retailers = DB::table('retailers')->where('title', 'REGEXP', '^[0-9]')->orderBy('title')->get();
        }else {
            $retailers = DB::table('retailers')->where('title', 'LIKE', $char.'%')->orderBy('title')->get();
        }

        return json_encode($retailers);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required', 
            'user_id' => 'required', 
            'title' => 'required', 
            'meta' => 'max:191', 
            'description' => 'max:1000',
            'url' => 'max:191',
            'mid' => 'required'
        ]);
        $retailer = new Retailer;
        $retailer->title = $request->input('title');
        $retailer->slug = $request->input('slug');
        $retailer->user_id = $request->input('user_id');
        $retailer->meta = $request->input('meta');
        $retailer->description = $request->input('description');
        $retailer->url = $request->input('url');
        $retailer->tracking_url = $request->input('tracking_url');
        $retailer->mid = $request->input('mid');
        //Handle logo upload
        if($request->hasFile('logo')){
            $ext = $request->file('logo')->getClientOriginalExtension();
            $filename_save = 'logo_'.$request->input('mid').'.'.$ext;       
            $file = $request->file('image')->storeAs('public/images/retailers/', $filename_save);
            $retailer->logo = 'public/images/retailers/'.$filename_save;
        }
        $retailer->save();

       return $retailer;
    }
   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Retailer  $retailer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $mid)
    {
        $this->validate($request, [
            'slug' => 'required', 
            'user_id' => 'required', 
            'title' => 'required', 
            'meta' => 'max:191', 
            'description' => 'max:1000',
            'url' => 'max:191',
            'tracking_url' => 'max:191',
            'mid' => 'required'
        ]);
        $retailer = Retailer::find($mid);
        $retailer->title = $request->input('title');
        $retailer->slug = $request->input('slug');
        $retailer->user_id = $request->input('user_id');
        $retailer->meta = $request->input('meta');
        $retailer->description = $request->input('description');
        $retailer->url = $request->input('url');
        $retailer->tracking_url = $request->input('tracking_url');
        $retailer->mid = $request->input('mid');
        //Handle logo upload
        if($request->hasFile('logo')){
            if(file_exists($retailer->logo)){
                unlink($retailer->logo);
            }
            $ext = $request->file('logo')->getClientOriginalExtension();
            $filename_save = 'logo_'.$request->input('mid').'.'.$ext;       
            $file = $request->file('image')->storeAs('public/images/retailers/', $filename_save);
            $retailer->logo = 'public/images/retailers/'.$filename_save;
        }
        $retailer->update();
        return $retailer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Retailer  $retailer
     * @return \Illuminate\Http\Response
     */
    public function destroy($mid)
    {
        $retailer = Retailer::find($mid);
        $retailer->delete();
        return $retailer;
    }

    /**
     * Upload images for retailer logos
     */
    public function upload(Request $request, $mid)
    {
        //Handle logo upload
        if($request->hasFile('logo')){
            //Get logo extension
            $ext = $request->file('logo')->getClientOriginalExtension();
            $filename_save = 'logo_'.$mid.'.'.$ext;       
            $file = $request->file('logo')->storeAs('/images/retailers/logos/', $filename_save);
            $request->logo->move(public_path('/images/retailers/logos/'), $filename_save);      
       
            $retailer = Retailer::find($mid);
            $retailer->logo = '/images/retailers/logos/'.$filename_save;
            $retailer->update();

        }
            return $retailer->logo;
    }

    /**
     * Process the uploaded file.
     */
    public function csvProcess(Request $request, $prefix)
    {

        //Handle csv upload
        if($request->hasFile('csv_file')){
            //Get file extension
           // $ext = $request->file('csv_file')->getClientOriginalExtension();
            $filename_save = 'retailers.csv';       
            $file = $request->file('csv_file')->storeAs('/datafeeds', $filename_save);

        }
        $handle = fopen($request->file('csv_file'), 'r');
        $i = 0;
        while (($data = fgetcsv($handle, 0, ',')) !== FALSE){
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
}
