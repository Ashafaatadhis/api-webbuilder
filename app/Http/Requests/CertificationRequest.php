<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch ($this->route()->getName()) {
            case "certification.add":
                return $this->addRule();
            case "certification.update":
                return $this->updateRule();
            default:
                return [];
        }
    }

    protected function addRule(): array
    {
        return [
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'image' => 'required|file|max:5120',
            'store_id' => 'required|string|exists:stores,id|max:255',
        ];
    }
    protected function updateRule(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'issuer' => 'nullable|string|max:255',
            'image' => 'nullable|file|max:5120',
            'store_id' => 'nullable|string|exists:stores,id|max:255',
        ];
    }
}
