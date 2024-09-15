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
                Rule::unique('templates')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ],
            'store_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('templates')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'templateCategory_id' =>   'required|string|exists:template_category,id|max:255',
        ];
    }
    protected function updateRule(): array
    {
        $id =  request()->route("template");
        return [
            'name' => 'nullable|string|max:255',
            'store_id' => [
                'nullable',
                'string',
                'max:255',
            ],
            'templateCategory_id' =>   'nullable|string|exists:template_category,id|max:255',
        ];
    }
}
