<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                          => $this->id,
            'attribute_name'              => $this->attribute_name,
            'attribute_value'             => $this->attribute_value,
            'unit_price'                  => number_format($this->unit_price),
            'stock'                       => $this->stock,
            'discount_type'               => $this->discount_type,
            'attribute_discount_amount'   => round($this->getAttributeDiscountAmount(), 2),
            'discount_percentage'         => round($this->getDiscountPercentage(), 2),
            'discounted_price'            => round($this->getDiscountedPrice(), 2),
            'formated_discount_price'     => number_format($this->getDiscountedPrice()) . ' BDT',
        ];
    }
}
