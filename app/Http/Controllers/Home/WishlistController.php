<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function add(Product $product)
    {
        if (auth()->check()) {
            if($product->checkWishlist(auth()->id())){
                alert()->error('دقت کنید','این محصول قبلا به لیست علاقه مندی ها اضافه شده است')->persistent("بستن");
                return redirect()->back();
            }else{
                Wishlist::create([
                    "user_id" => auth()->id(),
                    "product_id" => $product->id
                ]);
                alert()->success('موفق','محصول با موفقیت به لیست علاقه مندی ها اضافه شد')->persistent("بستن");
                return redirect()->back();
            }
        }else{
            alert()->error('دقت کنید','برای اضافه کردن محصول به لیست علاقه مندی ها باید ابتدا وارد سایت شوید')->persistent("بستن");
            return redirect()->back();
        }
    }

    public function remove(Product $product)
    {
        if (auth()->check()) {
            if($product->checkWishlist(auth()->id())){

                $wishlist = Wishlist::where("product_id" , $product->id)->where("user_id" , auth()->id())->first();
                if ($wishlist) {
                    Wishlist::where("product_id" , $product->id)->where("user_id" , auth()->id())->delete();
                }

                alert()->success('موفق','محصول با موفقیت از لیست علاقه مندی ها حذف شد')->persistent("بستن");
                return redirect()->back();
            }else{
                alert()->error('دقت کنید','این محصول در لیست علاقه مندی ها وجود ندارد')->persistent("بستن");
                return redirect()->back();
            }
        }else{
            alert()->error('دقت کنید','برای اضافه کردن محصول به لیست علاقه مندی ها باید ابتدا وارد سایت شوید')->persistent("بستن");
            return redirect()->back();
        }
    }

    public function showInProfile()
    {
        $userWishlists = Auth::user()->wishlist()->paginate(10);
        // $userWishlists = Wishlist::where("user_id" , auth()->id())->paginate(10);
        return view("home.profile.wishlist" , compact("userWishlists"));
    }
}
