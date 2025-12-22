<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function defaultAttribute()
    {
        return $this->hasOne(ProductAttribute::class)->where('is_default', 1);
    }


    public function attributeImages()
    {
        return $this->hasManyThrough(
            ProductAttributeImage::class,
            ProductAttribute::class,
            'product_id',       // Foreign key on product_attributes
            'attribute_id',     // Foreign key on product_attribute_image
            'id',               // Local key on products
            'id'                // Local key on product_attributes
        );
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
