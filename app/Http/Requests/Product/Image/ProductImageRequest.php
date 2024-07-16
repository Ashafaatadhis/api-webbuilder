<?php

namespace App\Http\Requests\Product\Image;

use Illuminate\Foundation\Http\FormRequest;


class ProductImageRequest extends FormRequest
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
            case "product.image.add":
                return $this->addRule();
                return $this->addRule();
            case "product.image.update":
                return $this->updateRule();
            default:
                return [];
        }
    }

    protected function addRule(): array
    {
        return is_array(request("file")) ?  [
            "file.*" => 'required|file',

            'product_id' => 'required|exists:products,id|string|max:255',
        ] : [
            "file" => 'required|file',
            'product_id' => 'nullable|exists:products,id|string|max:255',
        ];
    }
    protected function updateRule(): array
    {
        // dd(request());
        return [
            "file" => 'required|file',
        ];
    }
}
