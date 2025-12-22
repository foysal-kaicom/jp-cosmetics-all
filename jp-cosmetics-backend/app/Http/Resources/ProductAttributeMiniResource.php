<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeMiniResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (!$this->resource) return [];

        return [
            'id'              => $this->id,
            'product_id'      => $this->product_id,
            'attribute_name'  => $this->attribute_name,
            'attribute_value' => $this->attribute_value,
        ];
    }
}
