<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "attributes";
    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function categories(){
        return $this->belongsToMany(Category::class , "attribute_category");
    }


    public function attributeValue(){
        return $this->hasMany(ProductAttribute::class)->select("attribute_id" , "value")->distinct();
    }
    
    public function variationValue(){
        return $this->hasMany(ProductVariation::class)->select("attribute_id" , "value")->distinct();
    }
}
