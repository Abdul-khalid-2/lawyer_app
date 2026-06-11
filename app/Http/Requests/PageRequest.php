<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('super_admin') ?? false;
    }

    public function rules(): array
    {
        $page = $this->route('page');

        return [
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('pages', 'slug')->ignore($page?->id)],
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
        ];
    }
}
