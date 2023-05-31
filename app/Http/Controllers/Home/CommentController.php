<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request , Product $product)
    {
        // dd($request->all() , $product);

        $validator = Validator::make($request->all() , [
            "review_text" => "required",
            "rate" => "required"
        ]);

        if($validator->fails()){
            return redirect()->to( url()->previous() . "#product_detail" )->withErrors($validator);
        }


        if(auth()->check()){
            try {
                DB::beginTransaction();

                Comment::create([
                    "user_id" => auth()->id(),
                    "product_id" => $product->id,
                    "text" => $request->review_text,
                ]);
    
                if($product->rates()->where("user_id" , auth()->id())->exists()){
                    $productRate = $product->rates()->where("user_id" , auth()->id())->first();
                    $productRate->update([
                        "rate" => $request->rate,
                    ]);
                }else{
                    ProductRate::create([
                        "user_id" => auth()->id(),
                        "product_id" => $product->id,
                        "rate" => $request->rate,
                    ]);
                }
    
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
                alert()->error('مشکل در ثبت نظر', $ex->getMessage())->persistent("بستن");
                return redirect()->back();
            }
    
            alert()->success('موفق','نظر شما ثبت شد و پس از تایید کارشناسان ما در سایت نمایش داده می شود');
            return redirect()->back();

        }else{
            alert()->error('ابتدا وارد شوید', 'برای ثبت نظر در سایت ابتدا باید ثبت نام/ورود کنید')->persistent("بستن");
            return redirect()->back();
        }


    }

    public function profileUserComments()
    {
        $comments = Auth::user()->comments()->paginate(10);
        return view("home.profile.comments" , compact("comments"));
    }
}
