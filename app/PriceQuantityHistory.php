<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceQuantityHistory extends Model
{
    public $timestamps = false;

    protected $fillable = ['product_id', 'price', 'quantity', 'created_at', 'updated_at'];
}
