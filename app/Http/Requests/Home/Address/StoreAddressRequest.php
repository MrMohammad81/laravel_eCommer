<?php

namespace App\Http\Requests\Home\Address;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
        return $this->validateWithBag('addressStore' , [
            'store_title' => 'required|min:3',
            'mobile' => 'required|iran_mobile',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required|min:10',
            'postal_code' => 'required|iran_postal_code',
        ]);
    }
}
