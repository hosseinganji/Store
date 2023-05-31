<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = "product_attributes";
    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
}
