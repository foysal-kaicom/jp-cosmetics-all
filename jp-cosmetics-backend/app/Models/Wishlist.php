<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'added_at' => 'datetime',
    ];
    

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    public function defaultAttribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id')
            ->withDefault(function ($attr) {
                return $this->product->defaultAttribute();
            });
    }

}
