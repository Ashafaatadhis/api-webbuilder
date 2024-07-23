<?php

namespace App\Http\Requests\Store\Image;

use Illuminate\Foundation\Http\FormRequest;


class StoreImageRequest extends FormRequest
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
            case "store.image.add":
                return $this->addRule();

            case "store.image.update":
                return $this->updateRule();
            default:
                return [];
        }
    }

    protected function addRule(): array
    {

        return is_array(request("file")) ?  [
            "file.*" => 'required|file|max:5120',

            'store_id' => 'required|string|exists:stores,id|max:255',
        ] : [
            "file" => 'required|file|max:5120',
            'store_id' => 'nullable|string|exists:stores,id|max:255',
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
