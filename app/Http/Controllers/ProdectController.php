<?php

namespace App\Http\Controllers;

use App\Models\Prodect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword: null;

        // $products = Prodect::latest()->get();
        $products = Prodect::orderBy('id','desc');
        if(!is_null($keyword)){
            $products = $products->search($keyword,null,true);
        }
        $products = $products->get();
        return view('products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr = [];
        $niceName=[];

        foreach(config('locales.languages') as $key => $value){
            $attr['title.'. $key] = 'required';
            $attr['dec.'. $key] = 'required';
            $attr['price.'. $key] = 'required';
            //
            $niceName['title.'. $key] = __('prodects.title') . '('.$value['name'] .')';
            $niceName['dec.'. $key] = __('prodects.dec'). '('.$value['name'] .')';
            $niceName['price.'. $key] = __('prodects.price'). '('.$value['name'] .')';
        }
        $validation = Validator::make($request->all(), $attr);
        $validation->setAttributeNames($niceName);
        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data['title'] = $request->title;
        $data['dec'] = $request->dec;
        $data['price'] = $request->price;

        $product = Prodect::create($data);
        if($product){
            return redirect()->route('products.show', $product)->with([
                'message' => __('prodects.created_successfully'),
                'alert-type'=> 'success'
            ]);
        }
        return redirect()->route('products.show', $product)->with([
            'message' => __('prodects.something_was_wrong'),
            'alert-type'=> 'danger'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prodect  $prodect
     * @return \Illuminate\Http\Response
     */
    // public function show(Prodect $prodect)
    public function show($prodect) // show( $prodect) if hundel slag her
    {
        // If not using Model in param and not hundel slag in model in func  getRouteKeyName()
        $product = Prodect::where('slug->'. app()->getLocale(), $prodect)->first();

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prodect  $prodect
     * @return \Illuminate\Http\Response
     */
    public function edit($prodect)
    {
        $product = Prodect::where('slug->'. app()->getLocale(), $prodect)->first();

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prodect  $prodect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $prodect)
    {
        $attr= $niceName = [];

        foreach (config('locales.languages') as $key => $value) {
            $attr['title.'. $key] = 'required';
            $attr['dec.'. $key] = 'required';
            $attr['price.'. $key] = 'required';
            //
            $niceName['title.'. $key] = __('prodects.title') . '('.$value['name'] .')';
            $niceName['dec.'. $key] = __('prodects.dec'). '('.$value['name'] .')';
            $niceName['price.'. $key] = __('prodects.price'). '('.$value['name'] .')';
        }
        $validation = Validator::make($request->all(), $attr);
        $validation->setAttributeNames($niceName);
        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data['title'] = $request->title;
        $data['dec'] = $request->dec;
        $data['price'] = $request->price;

        $product = Prodect::where('slug->'. app()->getLocale(), $prodect)->first();
        $product->update($data);
        if($product){
            return redirect()->route('products.show', $product)->with([
                'message' => __('prodects.updated_successfully'),
                'alert-type'=> 'success'
            ]);
        }
        return redirect()->route('products.show', $product)->with([
            'message' => __('prodects.something_was_wrong'),
            'alert-type'=> 'danger'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prodect  $prodect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prodect $prodect)
    {
        $product = Prodect::where('slug->'. app()->getLocale(), $prodect)->first()->delete();
        if($prodect){
            return redirect()->route('products.index')->with([
                'message' => __('prodects.deleted_successfully'),
                'alert-type'=> 'success'
            ]);
        }
        return redirect()->route('products.index')->with([
            'message' => __('prodects.something_was_wrong'),
            'alert-type'=> 'danger'
        ]);
    }
}
