<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::active()->latest()->limit(8)->get();
        return view('front.home', compact('products'));
    }
}
