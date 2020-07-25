<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'EAN' => 'required|string|min:12|max:13',
            'type' => 'required|string',
            'weight' => 'required|numeric|max:5',
            'color' => 'required|starts_with:#|min:7|max:7',
            'image' => 'required|url'
        ];
    }
}
