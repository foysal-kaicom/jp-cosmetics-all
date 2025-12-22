<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $rules = [
            'name'          => ['required', 'string', 'max:255'],
            'slug'          => ['nullable', 'string', 'max:255'],
            'category_id'   => ['required', 'exists:categories,id'],
            'brand_id'      => ['nullable', 'exists:brands,id'],
            'primary_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:4096'],  // Default nullable
            'product_type'  => ['required', 'in:single,configurable,digital'],
            'status'        => ['required', 'in:active,inactive,out_of_stock'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'long_description' => ['nullable','string', 'max:5000'],
            'ingredients' => ['nullable','string', 'max:5000'],
            'how_to_use' => ['nullable','string', 'max:5000'],

    
            // Attributes rules
            'attributes'                       => ['array'],
            'attributes.*.id'                  => ['nullable', 'integer', 'max:1000'],
            'attributes.*.product_id'          => ['nullable', 'integer', 'max:1000'],
            'attributes.*.attribute_name'      => ['required', 'string', 'max:100'],
            'attributes.*.attribute_value'     => ['required', 'string', 'max:150'],
            'attributes.*.unit_price'          => ['required', 'numeric'],
            'attributes.*.stock'               => ['required', 'integer', 'min:0'],
            'attributes.*.min_order'           => ['nullable', 'integer', 'min:1'],
            'attributes.*.max_order'           => ['nullable', 'integer', 'min:1'],
            'attributes.*.discount_type'       => ['nullable', 'in:fixed,percentage'],
            'attributes.*.discount_amount'     => ['nullable', 'numeric', 'min:0'],
            'attributes.*.status'              => ['nullable', 'in:0,1'],
            'attributes.*.is_default'          => ['nullable', 'in:on,off'],

            'attributes.*.attribute_images'   => ['array'],
            'attributes.*.attribute_images.*' => ['image', 'mimes:jpg,jpeg,png,webp,avif', 'max:4096'],
        ];

        if ($this->isMethod('POST')) {
            $rules['primary_image'] = ['required', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:4096']; // Make it required only for POST (create)
        }
    
        return $rules;
    }
    
}
