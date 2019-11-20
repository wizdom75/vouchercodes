<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::paginate(10);
    }
    public function getAll()
    {
        return Category::orderBy('title')->get();
    }
    public function adminIndex()
    {
        return Category::orderBy('title')->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required'
        ]);

        $category = new Category;

        if(is_numeric($request->input('parent_id'))){
            $parent_id = $request->input('parent_id');
        }else{
            $parent_id = 0;
        }

        $category->parent_id = $parent_id;
        $category->title = $request->input('title');
        $category->slug = $this->makeSlug($request->input('slug'));
        $category->description = $request->input('description');
        
        $category->save();

        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'title' => 'required',
            'slug' => 'required'
        ]);

        $category = Category::find($id);

        if(is_numeric($request->input('parent_id'))){
            $parent_id = $request->input('parent_id');
        }else{
            $parent_id = 0;
        }

        $category->parent_id = $parent_id;
        $category->title = $request->input('title');
        $category->slug = $this->makeSlug($request->input('slug'));
        $category->description = $request->input('description');
        
        $category->update();

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
         $category->delete();

         return 'Success';
    }
    /**
     * Process the uploaded file.
     */
    public function csvProcess(Request $request)
    {

        //Handle csv upload
        if($request->hasFile('csv_file')){
            $filename_save = 'categories.csv';       
            $file = $request->file('csv_file')->storeAs('/datafeeds', $filename_save);

        }
        $handle = fopen($request->file('csv_file'), 'r');
        $i = 0;
        while (($data = fgetcsv($handle, 0, ',')) !== FALSE){
            if($i === 0){

            }else{
                $m = Category::find($data[0]);
                $r = Category::where('slug', $this->makeSlug($data[2]))->first();
                if($m || $r){
                    echo 'Duplicate record skipped';
                    continue;
                }else{

                $category = new Category;
                $category->id = trim($data[0]);
                $category->parent_id = trim($data[1]);
                $category->title = trim($data[2]);
                $category->slug = $this->makeSlug($data[2]);
                $category->save();
                }
            }
            $i++;
        }
        fclose($handle);
    }

    public function makeSlug($string)
    {
        $string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
        $string = preg_replace("/(\W)+/", "-", $string);

        $string = strtolower($string);
        
        return $string;

    }
}
