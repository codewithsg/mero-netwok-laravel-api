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
        $products = DB::select('select * from products');
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
}
