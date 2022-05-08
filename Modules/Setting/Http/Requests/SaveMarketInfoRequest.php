<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveMarketInfoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'               => 'required|string',
            'economicCode'       => 'required',
            'registrationNumber' => 'required|string',
            'description'        => 'required|string',
            'socialMedia'        => 'array',
            'email'              => 'required|email',
            'phone'              => 'required|numeric',
            'mobile'             => 'required|numeric|size:11',
            'zipcode'            => 'required',
            'city'               => 'required',
            'province'           => 'required',
            'address'            => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
