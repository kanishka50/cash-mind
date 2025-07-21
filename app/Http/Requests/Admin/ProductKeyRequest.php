<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductKeyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'key_count' => 'nullable|integer|min:1',
        ];
        
        if ($this->has('bulk_keys')) {
            $rules['bulk_keys'] = 'required|string';
        } else {
            $rules['key_value'] = 'required|string';
        }
        
        return $rules;
    }
}