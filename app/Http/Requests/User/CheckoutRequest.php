<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        return [
            'coupon_code' => 'nullable|string|max:50',
            'payment_method' => 'required|in:bank_transfer', // Changed from 'stripe' to 'bank_transfer'
            'terms_accepted' => 'required|accepted',
            'notes' => 'nullable|string|max:500', // Add notes validation
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'terms_accepted.accepted' => 'You must accept the terms and conditions to proceed with checkout.',
        ];
    }
}