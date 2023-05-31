<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Request $request , Product $product)
    {
        return view("home.product.show" , compact("product"));
    }
}
