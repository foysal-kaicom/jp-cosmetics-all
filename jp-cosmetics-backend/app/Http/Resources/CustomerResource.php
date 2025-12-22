<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'image'      => $this->image ? asset($this->image) : null,
            'status'     => $this->status,

            'addresses' => CustomerAddressResource::collection($this->addresses),

            'default_address' => $this->defaultAddress
                ? new CustomerAddressResource($this->defaultAddress)
                : null,
        ];
    }
}
