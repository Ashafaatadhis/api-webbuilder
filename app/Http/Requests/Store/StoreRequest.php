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
            'logo' => 'required|file|max:5120',

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
            'location' => 'string|nullable',
            'logo' => 'file|nullable|max:5120',
        ];
    }
}
