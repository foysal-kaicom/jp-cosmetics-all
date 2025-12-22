<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerAddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'city'       => $this->city,
            'area'       => $this->area,
            'address'    => $this->address,
            'status'     => (bool) $this->status,
            'is_default' => (bool) $this->is_default,
        ];
    }
}
