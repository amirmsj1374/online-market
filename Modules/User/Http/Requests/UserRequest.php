<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    protected $validationArray = [
        'address'  => 'nullable',
        'city'     => 'nullable',
        'name'     => 'required',
        'password' => 'required',
        'phone'    => 'nullable',
        'province' => 'nullable',
        'role'     => 'required',
        'status'   => 'required',
    ];

    public function rules()
    {
        if ($this->has('user_id')) {
            $this->validationArray += [
                'email'    => 'required|unique:users,email,' . $this->user_id,
                'mobile'    => 'nullable|unique:users,mobile,' . $this->user_id,
            ];
        } else {
            $this->validationArray += [
                'email'    => 'required|unique:users,email',
                'mobile'    => 'nullable|unique:users,mobile',
            ];
        }

        return $this->validationArray;
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
