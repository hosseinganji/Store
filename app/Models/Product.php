<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = "products";
    protected $guarded = [];

    protected $dates = ['deleted_at'];
    
    protected $appends = ['price_check' , 'in_stock'];


    
    public function scopeFilter($query){
        // send products after filter in variation
        if(request()->has("variation"))
        {
            $query->whereHas("variations" , function($query){
                foreach( explode('-' , request('variation')) as $index => $variationValue ){
                    if($index == 0){
                        $query->where("value" , $variationValue);
                    }else{
                        $query->orWhere("value" , $variationValue);
                    }
                }
            });
        }

        // send products after filter in attributes
        if(request()->has("attribute"))
        {
            foreach(request()->attribute as $attribute){
                // dd($attribute);
                $query->whereHas("attribute" , function($query) use($attribute){
                    foreach( explode('-' , $attribute) as $index => $attributeValue ){
                        if($index == 0){
                            $query->where("value" , $attributeValue);
                        }else{
                            $query->orWhere("value" , $attributeValue);
                        }
                    }
                });
            }
        }
        
        // send products after filter in sorting
        if(request()->has("sorting"))
        {
            if(request('sorting') == "latest"){ $query->oldest(); }
            elseif(request('sorting') == "newest"){ $query->latest(); }
            elseif(request('sorting') == "max"){ 
                $query->orderByDesc(
                  ProductVariation::select("price")->whereColumn("product_variations.product_id" , "products.id")->orderBy("sale_price" , "desc")->take(1)  
                );
            }
            elseif(request('sorting') == "min"){ 
                $query->orderBy(
                  ProductVariation::select("price")->whereColumn("product_variations.product_id" , "products.id")->orderBy("sale_price" , "asc")->take(1)  
                );
            }
            
        }

    }
    
    


    public function tags(){
        return $this->belongsToMany(Tag::class , "product_tag");
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function attributes(){
        return $this->belongsToMany(Attribute::class , "product_attributes");
    }
    
    // advice it:
    public function attribute(){
        return $this->hasMany(ProductAttribute::class);
    }
    
    public function variations(){
        return $this->hasMany(ProductVariation::class);
    }


    public function images(){
        return $this->hasMany(ProductImage::class);
    }


    public function getPriceCheckAttribute(){
        return $this->variations()->where("quantity" , ">" , 0)->where("sale_price" , "!=" , null)->where("date_on_sale_from" , "<" , Carbon::now())->where("date_on_sale_to" , ">" , Carbon::now())->first() ?? false;
    }
 
    
    public function getInStockAttribute(){
        return count($this->variations->where("quantity" , ">" , 0)) == 0 ? false : true ;
    }


    public function rates(){
        return $this->hasMany(ProductRate::class);
    }
    
    
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function checkWishlist($userId)
    {
        return $this->hasMany(Wishlist::class)->where("user_id" , $userId)->exists();
    }
    

}
