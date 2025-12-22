<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required','string','max:255'],
            'parent_id'   => ['nullable','integer','exists:categories,id'],
            'slug'        => ['nullable','string','max:255'],
            'sequence'    => ['required','integer','min:0'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:2048'],
            'is_popular'  => ['nullable','boolean'],
        ];
    }
}
