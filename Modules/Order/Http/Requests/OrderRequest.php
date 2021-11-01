<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'form.fullname' => 'required',
            'form.address'  => 'required',
            'form.zipcode'  => 'required',
            'form.city'     => 'required',
            'form.province' => 'required',
            'form.phone'    => 'required|numeric',
            'form.email'    => 'nullable|email',
            'cart'          => 'array',
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

    public function messages()
    {
        return [
            'form.fullname.required' => 'لطفا نام و نام خانوادگی را وارد کنید',
            'form.address.required'  => 'لطفا آدرس مقصد را وارد کنید',
            'form.zipcode.required'  => 'لطفا کد پستی را وارد کنید',
            'form.city.required'     => 'لطفا شهر را وارد کنید',
            'form.province.required' => 'لطفا استان را وارد کنید',
            'form.phone.required'    => 'لطفا تلفن تماس را وارد کنید',
            'form.phone.numeric'     => 'شماره تماس معتبر نیست',
            'form.email.email'       => 'ایمیل وارد شده معتبر نیست',
            'cart.array'             => 'سبد خرید نباید خالی باشد',
        ];
    }
}
