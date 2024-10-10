<?php

namespace App\Http\Requests\Template;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TemplateRequest extends FormRequest
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
            case "template.add":
                return $this->addRule();
            case "template.update":
                return $this->updateRule();
            default:
                return [];
        }
    }

    protected function addRule(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                "unique:templates,name"
            ],
            'link' => [
                'required',
                'string',
                'max:255',
                "unique:templates,link"
            ],
            'image' => 'required|file|max:10240',
            'templateCategory_id' =>   'required|string|exists:template_category,id|max:255',
        ];
    }
    protected function updateRule(): array
    {

        $id = $this->route('template');

        return [
            'name' => ["nullable", "string", "max:255", Rule::unique('templates')->ignore($id)],
            'link' => ["nullable", "string", "max:255", Rule::unique('templates')->ignore($id)],
            'image' => 'nullable|file|max:10240',
            'templateCategory_id' => 'nullable|string|exists:template_category,id|max:255',
        ];
    }
}
