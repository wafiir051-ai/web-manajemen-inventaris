<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'type',
        'product_id',
        'quantity',
        'price',
        'description',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
