<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'url' => 'nullable|url',
            'creator' => 'nullable',
            'last_modified_t' => 'nullable|date',
            'product_name' => 'nullable',
            'quantity' => 'nullable',
            'brands' => 'nullable',
            'categories' => 'nullable',
            'labels' => 'nullable',
            'cities' => 'nullable',
            'purchase_places' => 'nullable',
            'stores' => 'nullable',
            'ingredients_text' => 'nullable',
            'traces' => 'nullable',
            'serving_size' => 'nullable',
            'serving_quantity' => 'nullable',
            'nutriscore_score' => 'nullable|numeric',
            'nutriscore_grade' => 'nullable|numeric',
            'main_category' => 'nullable',
            'image_url' => 'nullable|url',
        ];
    }
}
