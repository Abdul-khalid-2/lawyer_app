<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->lawyer !== null;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'years_of_experience' => 'nullable|integer|min:0|max:60',
            'order' => 'nullable|integer|min:0',
        ];
    }
}
