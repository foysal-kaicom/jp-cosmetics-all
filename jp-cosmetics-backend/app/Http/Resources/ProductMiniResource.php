<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductMiniResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (!$this->resource) return [];

        return [
            'id'   => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'primary_image' => $this->primary_image,
        ];
    }
}
