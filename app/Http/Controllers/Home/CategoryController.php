<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category){

        $attributes = $category->attributes()->where("is_filter" , 1)->with("attributeValue")->get();
        
        $variations = $category->attributes()->where("is_variation" , 1)->with("variationValue")->first();

        $products = $category->product()->filter()->paginate(20);

        // dd($products);

        return view("home.category.show" , compact("category" , "attributes" , "variations" , "products"));
    }
}
