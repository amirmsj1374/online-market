<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ProductRequest extends FormRequest
{
    protected $validationArray = [
        'body'         => 'nullable|string',
        'description'  => 'required|string',
        'downloadable' => 'nullable|boolean',
        'final_price'  => 'nullable',
        'height'       => 'nullable',
        'length'       => 'nullable',
        'publish'      => 'nullable|boolean',
        'sku'          => 'nullable|string',
        'tags'         => 'nullable',
        'tax_status'   => 'nullable|boolean',
        'title'        => 'required|string',
        'virtual'      => 'nullable|boolean',
        'weight'       => 'nullable',
        'width'        => 'nullable',
        'inventories'  => 'nullable',
        // 'min_quantity' => 'nullable',
        // 'quantity'     => 'nullable',
        // 'price'        => 'nullable',
    ];
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        foreach ($this->inventories as $key => $inventory) {

            $inventories[$key] = json_decode($inventory, true);
            $inventories[$key]['price'] = str_replace(',', '', $inventories[$key]['price']);
        }

        $this->request->set('inventories', $inventories);

        // $this->request->all()['inventories'][$key]['price'] = str_replace(',', '', json_decode($inventory, true)['price']);
        // $this->request->set('inventories.*' . '[price]', str_replace(',', '', json_decode($inventory, true)['price']));

        if ($this->hasFile('images') && count($this->images) > 0) {
            return array_merge($this->validationArray, ['images.*' => 'required|mimes:jpg,jpeg,png,bmp|max:2000']);
        } else {
            return $this->validationArray;
        }
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
            'images.*.required' => 'لطفا فقط فایل های تصویری را وارد کنید',
            'images.*.mimes' => 'تصاویر باید از نوع[jpeg,jpg,bnp] باشد',
            'images.*.max' => 'حداکثر حجم فیل باید2MB  باشد',
        ];
    }
}