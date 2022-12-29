<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|min:2',
            'brand_id' => 'required|integer',
            'is_active' => 'required|integer',
            'tag_ids' => 'required|array',
            'category_id' => 'required|integer',
            'primary_image' => 'required|mimes:png,jpg,jpeg,svg',
            'images' => 'required',
            'images.*' => 'mimes:png,jpg,jpeg,svg',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'required',
            'variation_values' => 'required',
            'variation_values.*.*' => 'required',
            'variation_values.price.*' => 'integer',
            'variation_values.quantity.*' => 'integer',
            'delivery_amount' => 'required|integer',
            'delivery_amount-per-product' => 'nullable|integer',
        ];
    }
}
