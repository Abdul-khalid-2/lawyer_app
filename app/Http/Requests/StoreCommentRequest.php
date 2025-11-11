<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'comment' => 'required|string|min:5|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ];

        // If user is not logged in, require name and email
        if (!auth()->check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email address',
            'comment.required' => 'Please enter your comment',
            'comment.min' => 'Comment must be at least 5 characters',
            'comment.max' => 'Comment must not exceed 1000 characters',
        ];
    }
}
