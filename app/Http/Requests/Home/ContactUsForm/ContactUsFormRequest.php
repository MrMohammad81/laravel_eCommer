<?php

namespace App\Http\Requests\Home\ContactUsForm;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsFormRequest extends FormRequest
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
            'name' => 'required|min:3|string',
            'cellphone' => 'required|iran_mobile',
            'email' => 'required|email',
            'subject' => 'required|min:5|string',
            'text' => 'required|max:750|string',
        ];
    }
}
