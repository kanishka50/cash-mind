<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Check if this is a chunked upload completion
        if ($this->has('uploaded_file_path')) {
            return [
                'course_id' => 'required|exists:courses,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'uploaded_file_path' => 'required|string',
                'duration' => 'nullable|integer',
                'order_number' => 'nullable|integer|min:1',
                'is_preview' => 'sometimes|boolean',
            ];
        }

        // Regular file upload validation
        return [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => $this->isMethod('post') ? 'required|file|mimes:mp4,mov,avi|max:2048000' : 'nullable|file|mimes:mp4,mov,avi|max:2048000', // 2GB Max
            'duration' => 'nullable|integer',
            'order_number' => 'nullable|integer|min:1',
            'is_preview' => 'sometimes|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_preview' => $this->has('is_preview'),
        ]);

        if (!$this->has('order_number')) {
            $this->merge(['order_number' => 1]);
        }
    }
}