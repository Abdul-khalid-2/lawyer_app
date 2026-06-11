<?php

namespace App\Http\Requests;

use App\Models\LegalCase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->lawyer !== null;
    }

    public function rules(): array
    {
        $lawyerId = $this->user()->lawyer->id;

        return [
            'client_id' => [
                'required',
                Rule::exists('clients', 'id')->where('lawyer_id', $lawyerId),
            ],
            'team_member_id' => [
                'nullable',
                Rule::exists('team_members', 'id')->where('lawyer_id', $lawyerId),
            ],
            'case_number' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::in(LegalCase::TYPES)],
            'court_name' => 'nullable|string|max:255',
            'judge_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(LegalCase::STATUSES)],
            'filed_date' => 'nullable|date',
        ];
    }
}
