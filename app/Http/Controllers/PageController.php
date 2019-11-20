<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Page::paginate(10);
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
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'type' => 'max:100',
            'body' => 'required'
        ]);

        $page = new Page;

        $page->title = $request->input('title');
        $page->slug = $request->input('slug');
        $page->type = $request->input('type');
        $page->body = $request->input('body');

        $page->save();

        return $page;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return $page;
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
    public function update(Request $request, $slug)
    {
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'type' => 'max:100',
            'body' => 'required'
        ]);

        $page = Page::find($slug);

        $page->title = $request->input('title');
        $page->slug = $request->input('slug');
        $page->type = $request->input('type');
        $page->body = $request->input('body');

        $page->update();

        return $page;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);

        $page->delete();

        return $page;
    }
}
