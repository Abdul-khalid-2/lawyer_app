<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->lawyer !== null;
    }

    public function rules(): array
    {
        $client = $this->route('client');

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($client?->user_id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:30',
            'cnic' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ];
    }
}
