<?php

namespace App\Http\Controllers;

use App\RetailerLocation;
use Illuminate\Http\Request;

class RetailerLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RetailerLocation::paginate(30);
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
            'ratailer_mid' => 'required', 
            'address_1' => 'max:60', 
            'address_2' => 'max:60', 
            'city' => 'max:50', 
            'county' => 'max:250',
            'post_code' => 'max:60',
            'telephone' => 'max:20'
        ]);
       return RetailerLocation::create($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RetailerLocation  $retailerLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RetailerLocation $retailerLocation)
    {
        $data = $request->validate([
            'ratailer_mid' => 'required', 
            'address_1' => 'max:60', 
            'address_2' => 'max:60', 
            'city' => 'max:50', 
            'county' => 'max:250',
            'post_code' => 'max:60',
            'telephone' => 'max:20'
        ]);

        return $retailerLocation->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RetailerLocation  $retailerLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(RetailerLocation $retailerLocation)
    {
        return $retailerLocation->delete();
    }
}
