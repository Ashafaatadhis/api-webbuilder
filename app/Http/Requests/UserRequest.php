<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            case "user.update":
                return $this->updateRule();
            default:
                return [];
        }
    }


    protected function updateRule(): array
    {
        return [
            'username' => 'nullable|string|max:255',
            'email' => 'nullable|string|unique:users,email|email|max:255',
            'role' => 'nullable|string|in:administrator,store_owner|max:255',
            'image' => 'nullable|file|max:5120',
            'password' => 'nullable|string|max:255',
        ];
    }
}
