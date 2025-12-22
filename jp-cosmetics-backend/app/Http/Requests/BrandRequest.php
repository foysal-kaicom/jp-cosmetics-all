<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'logo'        => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:2048'],
        ];
    }
}
