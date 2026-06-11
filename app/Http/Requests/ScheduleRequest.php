<?php

namespace App\Http\Requests;

use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->lawyer !== null;
    }

    public function rules(): array
    {
        $lawyerId = $this->user()->lawyer->id;

        return [
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::in(Schedule::TYPES)],
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'location' => 'nullable|string|max:255',
            'case_id' => [
                'nullable',
                Rule::exists('legal_cases', 'id')->where('lawyer_id', $lawyerId),
            ],
        ];
    }
}
