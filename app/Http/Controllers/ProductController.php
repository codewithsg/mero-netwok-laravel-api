<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //index -> show all listing;
    // show -> show single listing;
    // create -> show form to create new listing;
    // store -> store new listing;
    // edit -> show form to edit listing;
    // update -> update listing;
    // destroy -> delete listing;

    public function index(Request $request)
    {
        // $products = Product::latest();
        $products = DB::table('products')->get();
        return $products;
    }

    public function store(Request $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->category = $request->category;
        $product->description = $request->description;
        $product->product_image = $request->product_image;
        $product->user_id = $request->user_id;

        $product->save();

        return $product;
    }

    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->get();
        return $product;
    }

    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->delete();
        return $product;
    }

    public function update(Request $request, $id)
    {
        $product = DB::table('products')->where('id', $id)->update([
            'name' => $request->get('name'),
            'category' => $request->get('category'),
            'description' => $request->get('description'),
            'product_image' => $request->get('product_image')
        ]);
        return $product;
    }
}
