<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $defaultAttr = $this->defaultAttribute;
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'slug'              => $this->slug,
            'product_type'      => $this->product_type,
            'status'            => $this->status,
            'short_description' => $this->short_description,
            'long_description'  => $this->long_description,
            'ingredients'       => $this->ingredients,
            'how_to_use'        => $this->how_to_use,
            'primary_image'     => asset($this->primary_image),

            'category' => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug ?? null,
            ],

            'brand' => $this->brand ? [
                'id'   => $this->brand->id,
                'name' => $this->brand->name,
                'slug' => $this->brand->slug ?? null,
            ] : null,

            'created_at' => $this->created_at->format('Y-m-d'),
            'default_attribute' => $defaultAttr
            ? array_merge($defaultAttr->toArray(), [
                'discounted_price'        => $defaultAttr->getDiscountedPrice(),
                'attribute_discount_amount' => $defaultAttr->getAttributeDiscountAmount(),
                'discount_percentage'     => $defaultAttr->getDiscountPercentage(),
            ])
            : null,

        ];
    }
}
