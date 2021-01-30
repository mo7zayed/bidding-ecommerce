<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressesRequest extends FormRequest
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
            'name' => 'required|max:255',
            'country_id' => 'required|exists:countries,id',
            'address_1' => 'required|max:255',
            'city' => 'required|max:255',
            'postal_code' => 'required|numeric',
            'default' => 'sometimes|nullable',
        ];
    }
}
