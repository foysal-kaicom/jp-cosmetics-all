<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (!$this->resource) return [];

        return [
            'id'          => $this->id,
            'customer_id' => $this->customer_id,
            'title'       => $this->title,
            'city'        => $this->city,
            'area'        => $this->area,
            'address'     => $this->address,
            'status'      => $this->status,
            'is_default'  => $this->is_default,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
