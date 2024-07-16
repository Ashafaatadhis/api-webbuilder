<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            case "product.add":
                return $this->addRule();
            case "product.update":
                return $this->updateRule();
            default:
                return [];
        }
    }

    protected function addRule(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'string|nullable',
            'price' => 'required|numeric',
            'store_id' => 'required|string|exists:stores,id|max:255',
        ];
    }
    protected function updateRule(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'description' => 'string|nullable',
            'price' => 'nullable|numeric',
            'store_id' => 'nullable|string|exists:stores,id|max:255',
        ];
    }
}
