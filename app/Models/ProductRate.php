<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRate extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = "product_rates";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

}
