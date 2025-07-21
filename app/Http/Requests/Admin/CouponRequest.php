<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'max_uses' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:digital_products,id',
        ];

        // If updating, allow the coupon code to remain the same
        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['code'] = 'required|string|max:50|unique:coupons,code,' . $this->route('coupon')->id;
        }

        // Ensure percentage coupons don't exceed 100%
        if ($this->input('type') === 'percentage') {
            $rules['value'] = 'required|numeric|min:0|max:100';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'code.unique' => 'This coupon code already exists.',
            'valid_until.after_or_equal' => 'The end date must be after or equal to the start date.',
            'value.max' => 'The percentage discount cannot exceed 100%.',
        ];
    }
}