<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cities;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Provinces;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            "productVariations" => "required",
            "quantity" => "required",
            "product_id" => "required"
        ]);

        $product = Product::findOrFail($request->product_id);
        $productVariation = ProductVariation::findOrFail( json_decode($request->productVariations)->id );
        $rowId = $product->id . "-" . $productVariation->id;

        if($request->quantity > $productVariation->quantity){
            alert()->error('دقت کنید' , 'این تعداد از این محصول موجود نمی باشد')->persistent("بستن");
            return redirect()->back();
        }
        $items = \Cart::getContent();
        
        if(\Cart::get($rowId) == null){
            \Cart::add(array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $productVariation->is_sale == null ? $productVariation->price : $productVariation->sale_price,
                'quantity' => $request->quantity,
                'attributes' => $productVariation->toArray(),
                'associatedModel' => $product
            ));
        }else{
            alert()->error('دقت کنید' , 'این محصول در سبد خرید شما وجود دارد برای ویرایش به صفحه سبد خرید مراجعه کنید')->persistent("بستن");
            return redirect()->back();
        }

        alert()->success('موفق' , 'محصول به سبد خرید اضافه شد')->persistent("بستن");
        return redirect()->back();

    }

    public function show()
    {       
        return view("home.cart.show");
    }

    public function update(Request $request)
    {

        $request->validate([
            "quantity" => "required"
        ]);

        
        foreach($request->quantity as $rowId => $quantity){
            $item = \Cart::get($rowId);
            if($quantity > $item->attributes->quantity){
                alert()->error('دقت کنید' , 'تعداد درخواستی بیشتر از موجودی محصول می باشد')->persistent("بستن");
                return redirect()->back();
            }
            \Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                ),
              ));
        }

        alert()->success('موفق' , 'سبد خرید با موفقیت ویرایش شد')->persistent("بستن");
        return redirect()->back();
          
    }

    public function remove($rowId)
    {
        \Cart::remove($rowId);
        alert()->success('موفق' , 'محصول مورد نظر از سبد خرید شما حذف شد')->persistent("بستن");
        return redirect()->back();
    }


    public function clear()
    {
        \Cart::clear();
        alert()->success('موفق' , 'تمام محصولات از سبد خرید شما با موفقیت حذف شد')->persistent("بستن");
        return redirect()->back();
    }

    public function checkout()
    {
        $addresses = Address::where("user_id" , auth()->id())->get();
        $provinces = Provinces::get();
        $cities = Cities::get();
        return view("home.cart.checkout" , compact("provinces" , "addresses" , "cities"));
    }
}
