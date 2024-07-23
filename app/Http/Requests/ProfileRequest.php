<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            case "profile.update":
                return $this->updateRule();
            case "profile.password.update":
                return $this->updatePasswordRule();
            case "profile.delete":
                return $this->delete();
            default:
                return [];
        }
    }

    protected function delete(): array
    {
        return [
            "password" => 'required|string|max:255',
        ];
    }


    protected function updateRule(): array
    {
        return [
            'username' => 'nullable|string|max:255',
            'image' => 'nullable|file|max:5120',
        ];
    }
    protected function updatePasswordRule(): array
    {
        return [
            "password" => 'required|string|max:255',
            "new_password" => 'required|string|max:255',
        ];
    }
}
