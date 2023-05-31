<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function showInProfile()
    {
        $products = Product::find(session()->get("compareProduct"));
        return view("home.profile.compare" , compact("products"));
    }

    public function add(Product $product)
    {
        if(session()->get("compareProduct") == null ? null : in_array($product->id , session()->get("compareProduct"))){
            alert()->error('دقت کنید' , 'این محصول در لیست مقایسه وجود دارد')->persistent("بستن");
            return redirect()->back();
        }else{
            if (session()->has("compareProduct")) {
                session()->push("compareProduct" , $product->id);
            }else{
                session()->put("compareProduct" , [$product->id]);
            }

            alert()->success('موفق' , 'محصول با موفقیت به لیست مقایسه اضافه شد')->persistent("بستن");
            return redirect()->back();
        }
        
    }

    public function remove(Product $product)
    {
        if (session()->has("compareProduct")) {
            foreach (session()->get("compareProduct") as $key => $productId) {
                if($productId == $product->id){
                    session()->pull("compareProduct." . $key);
                }
            }
            alert()->success('موفق' , 'محصول با موفقیت از لیست مقایسه ها حذف شد')->persistent("بستن");
            return redirect()->back();

        }else{
            alert()->error('دقت کنید' , 'محصولی در لیست مقایسه وجود ندارد')->persistent("بستن");
            return redirect()->back();
        }
    }
}
