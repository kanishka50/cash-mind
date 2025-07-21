<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_featured' => 'sometimes|boolean',
            'category_id' => 'nullable|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048', // 2MB Max
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->filled('title') && !$this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }

        $this->merge([
            'is_featured' => $this->has('is_featured'),
        ]);
    }
}