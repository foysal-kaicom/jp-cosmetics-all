<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'order_number'   => $this->order_number,
            'payable_total'  => $this->payable_total,
            'products' => $this->details->pluck('product.name')->filter()->values(),
            'order_status'   => $this->status,
            'current_status' => $this->latestActivity?->to_status ?? $this->status,
            'created_at'     => $this?->created_at ?? $this->updated_at
        ];
    }
}
