<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSearchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $defaultAttr = $this->defaultAttribute;
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'image'         => asset($this->primary_image),
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
