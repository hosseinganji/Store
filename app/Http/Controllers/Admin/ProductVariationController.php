<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductVariation;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Mockery\Matcher\Pattern;

class ProductVariationController extends Controller
{
    public function store($variationValue , $product , $category){
        for($i = 0 ; $i < count($variationValue["value"]) ; $i++){
            ProductVariation::create([
                "attribute_id" => $category->attributes()->wherePivot("is_variation" , 1)->first()->id,
                "product_id" => $product->id,
                "value" => $variationValue["value"][$i],
                "price" => $variationValue["price"][$i],
                "quantity" => $variationValue["quantity"][$i],
                "sku" => $variationValue["sku"][$i],
            ]);
        }
    }

    public function update($variation_values){
        foreach ($variation_values as $var_id => $var_value) {
            $productvariation = ProductVariation::find($var_id);
            $productvariation->update([
                "value" => $var_value["value"],
                "price" => $var_value["price"],
                "quantity" => $var_value["quantity"],
                "sku" => $var_value["sku"],
                "sale_price" => $var_value["sale_price"],
                "date_on_sale_from" => convertJalaliToGregorianDate($var_value["date_on_sale_from"]),
                "date_on_sale_to" => convertJalaliToGregorianDate($var_value["date_on_sale_to"]),
            ]);
        }
    }

    public function change($variationValue , $productId , $category){

        ProductVariation::where("product_id" , $productId)->delete();

        for($i = 0 ; $i < count($variationValue["value"]) ; $i++){
            ProductVariation::create([
                "attribute_id" => $category->attributes()->wherePivot("is_variation" , 1)->first()->id,
                "product_id" => $productId,
                "value" => $variationValue["value"][$i],
                "price" => $variationValue["price"][$i],
                "quantity" => $variationValue["quantity"][$i],
                "sku" => $variationValue["sku"][$i],
                "sale_price" => $variationValue["sale_price"][$i] == null ? null :  $variationValue["sale_price"][$i],
                "date_on_sale_from" => convertJalaliToGregorianDate($variationValue["date_on_sale_from"][$i]) == null ? null : convertJalaliToGregorianDate($variationValue["date_on_sale_from"][$i]),
                "date_on_sale_to" => convertJalaliToGregorianDate($variationValue["date_on_sale_to"][$i]) == null ? null : convertJalaliToGregorianDate($variationValue["date_on_sale_to"][$i]),
            ]);
        }


    }
}
