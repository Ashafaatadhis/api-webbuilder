<?php

namespace App\Http\Requests\Template\Section;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HeroSectionRequest extends FormRequest
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
            case "template.section.hero.add":
                return $this->addRule();
            case "template.section.hero.update":
                return $this->updateRule();
            default:
                return [];
        }
    }

    protected function addRule(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|file|max:10240',
            'templateLink_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hero_section')
            ]
        ];
    }
    protected function updateRule(): array
    {
        $id = $this->route('hero');
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|file|max:10240',
            'templateLink_id' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('hero_section')->ignore($id)
            ]
        ];
    }
}
