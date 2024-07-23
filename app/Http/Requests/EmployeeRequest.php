<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            case "employee.add":
                return $this->addRule();
            case "employee.update":
                return $this->updateRule();
            default:
                return [];
        }
    }

    protected function addRule(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            "level" => "required|integer|between:1,5",
            'image' => 'file|required|max:5120',
            'store_id' => 'required|string|exists:stores,id|max:255',
        ];
    }
    protected function updateRule(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'file|nullable|max:5120',
            "level" => "nullable|integer|between:1,5",
            'store_id' => 'nullable|string|exists:stores,id|max:255',
        ];
    }
}
