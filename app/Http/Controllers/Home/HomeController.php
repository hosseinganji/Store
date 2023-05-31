<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $products = Product::find(12);
        // dd($products->id , $products->in_stock , $products->price_check);


        // dd($products->category->attributes()->wherePivot("is_variation" , 1)->first());
        

        $sliders = Banner::where("type" , "slider")->where("is_active" , 1)->orderBy("priority")->get();
        $topLeftBannerNextSlider = Banner::where("type" , "top_left_slider")->where("is_active" , 1)->orderBy("priority")->first();
        $buttomLeftBannerNextSlider = Banner::where("type" , "buttom_left_slider")->where("is_active" , 1)->orderBy("priority")->first();
        $offerLeft = Banner::where("type" , "offer_left")->where("is_active" , 1)->orderBy("priority")->first();
        $offerRight = Banner::where("type" , "offer_right")->where("is_active" , 1)->orderBy("priority")->first();

        $categories = Category::where("is_active" , 1)->where("parent_id" , "!=" , "0")->get();

        $special_products = Product::where("is_active" , 1)->get();

        $recent_products = Product::where("is_active" , 1)->orderBy("created_at" , "desc")->get();

        return view('home.home-page.homepage', 
            compact("sliders" , "topLeftBannerNextSlider" , "buttomLeftBannerNextSlider" , "offerLeft" , "offerRight" , "categories" , "special_products" , "recent_products"));
    }
}
