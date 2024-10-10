<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            case "store.add":
                return $this->addRule();
            case "store.update":
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
            'instagram' => "string|nullable",
            'facebook' => "string|nullable",
            'whatsapp' => "string|nullable",
            'location' => 'required|string',
            'gmaps' => 'required|string',
            'logo' => 'required|file|max:5120',
            'storeCategory_id' =>   'required|string|exists:store_category,id|max:255',

        ];
    }
    protected function updateRule(): array
    {
        return [
            'name' => 'string|nullable|max:255',
            'description' => 'string|nullable',
            'instagram' => "string|nullable",
            'facebook' => "string|nullable",
            'whatsapp' => "string|nullable",
            'location' => 'nullable|string',
            'gmaps' => 'nullable|string',
            'logo' => 'file|nullable|max:5120',
            'storeCategory_id' =>   'nullable|string|exists:store_category,id|max:255',
        ];
    }
}
