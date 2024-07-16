<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
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
            case "testimonial.add":
                return $this->addRule();
            case "testimonial.update":
                return $this->updateRule();
            default:
                return [];
        }
    }

    protected function addRule(): array
    {
        return [
            'content' => 'required|string|max:255',
            'author' => 'required|string',
            'store_id' => 'required|string|exists:stores,id|max:255',
        ];
    }
    protected function updateRule(): array
    {
        return [
            'content' => 'nullable|string|max:255',
            'author' => 'nullable|string',
            'store_id' => 'nullable|string|exists:stores,id|max:255',
        ];
    }
}
