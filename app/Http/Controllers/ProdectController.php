<?php

namespace App\Http\Controllers;

use App\Models\Prodect;
use Illuminate\Http\Request;

class ProdectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Prodect::latest()->get();
        return view('posts.index',compact('products'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prodect  $prodect
     * @return \Illuminate\Http\Response
     */
    public function show(Prodect $prodect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prodect  $prodect
     * @return \Illuminate\Http\Response
     */
    public function edit(Prodect $prodect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prodect  $prodect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prodect $prodect)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prodect  $prodect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prodect $prodect)
    {
        //
    }
}
