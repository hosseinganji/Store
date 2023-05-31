<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = "tags";
    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function products(){
        return $this->belongsToMany(Product::class , "product_tag");
    }


}
