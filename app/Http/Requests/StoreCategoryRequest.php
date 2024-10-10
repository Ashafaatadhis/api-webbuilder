<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
            case "store.category.add":
                return $this->addRule();
            case "store.category.update":
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
                Rule::unique('store_category')
            ],
        ];
    }
    protected function updateRule(): array
    {

        $id =  request()->route("stores");
        return [
            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('store_category')->ignore($id)
            ]
        ];
    }
}
