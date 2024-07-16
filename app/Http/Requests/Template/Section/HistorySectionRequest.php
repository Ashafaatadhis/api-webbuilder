<?php

namespace App\Http\Requests\Template\Section;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HistorySectionRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->route()->getName()) {
            case "template.section.history.add":
                return $this->addRule();
            case "template.section.history.update":
                return $this->updateRule();
            default:
                return [];
        }
    }

    protected function addRule(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'required|file|max:255',
            'template_id' => [
                'required', 'string', 'max:255',
                Rule::unique('history_section')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ]
        ];
    }
    protected function updateRule(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|file|max:255',
            'template_id' => [
                'nullable', 'string', 'max:255',

            ]
        ];
    }
}
