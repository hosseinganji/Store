<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function store($product , $attribute_get){
        foreach ($attribute_get as $attribute_id => $attribute_value) {
            ProductAttribute::create([
                "attribute_id" => $attribute_id,
                "product_id" => $product->id,
                "value" => $attribute_value
            ]);
        }
    }
    
    
    public function update($attributes_get){
        foreach ($attributes_get as $attribute_id => $attribute_value) {
            $productAttribute = ProductAttribute::find($attribute_id);
            $productAttribute->update([
                "value" => $attribute_value,    
            ]);
        }
    }
    
    
    public function change($attributes_get , $productId){

        ProductAttribute::where("product_id" , $productId)->delete();

        foreach ($attributes_get as $attribute_id => $attribute_value) {

            ProductAttribute::create([
                "attribute_id" => $attribute_id,
                "product_id" => $productId,
                "value" => $attribute_value
            ]);
        }

    }
}
