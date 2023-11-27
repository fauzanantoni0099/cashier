<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Picture;
use App\Product;
use App\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate();
        $createRoute = route('product.create');

        return view('products.index',compact('products','createRoute'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        $images = Image::all();
        return view('products.create',compact('categories','images','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $product = Product::create([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'unit_id'=>$request->unit_id,
            'description'=>$request->description,
            'purchase_price'=>$request->purchase_price,
            'selling_price'=>$request->selling_price,
            'profit'=>$request->selling_price - $request->purchase_price,
            'stock'=>$request->stock,
            'expired'=>$request->expired
        ]);

        $file = $request->file('name_path');
        $namaFile = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $namaFile);
        $fileLocation = 'uploads/'.$namaFile;

        $product->images()->create([
            'name_path' => $fileLocation,
            'imageable_id' => $product->id,
            'imageable_type' => Product::class
        ]);

        return redirect()->route('product.index',compact('product'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $units = Unit::all();
        $images = Image::all();
        return view('products.edit',compact('product','categories','images','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'unit_id'=>$request->unit_id,
            'description'=>$request->description,
            'purchase_price'=>$request->purchase_price,
            'selling_price'=>$request->selling_price,
            'profit'=>$request->selling_price - $request->purchase_price,
            'stock'=>$request->stock,
            'expired'=>$request->expired
        ]);
        if ($request->name_path) {
            $file = $request->file('name_path');
            $namaFile = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
            $fileLocation = 'uploads/' . $namaFile;

            $product->images()->update([
                'name_path' => $fileLocation,
                'imageable_id' => $product->id,
                'imageable_type' => Product::class
            ]);
        }
        return redirect()->route('product.index',compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index',compact('product'));
    }
    public function order()
    {
        return view('orders.index');
    }
}
