<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Setting\Entities\MarketAddress;
use Modules\Setting\Entities\Setting;

class SettingController extends Controller
{
    public function saveMarketInfo(Request $request)
    {

        $setting = Setting::first();

        $settingData = [
            'name'               => $request->name,
            'economicCode'       => $request->economicCode,
            'registrationNumber' => $request->registrationNumber,
            'description'        => $request->description,
            'socialMedia'        => $request->socialMedia,
        ];

        if (is_null($setting)) {
            Setting::create($settingData);
        } else {
            $setting->update($settingData);
        }

        $addressData = [
            'email'    => $request->email,
            'phone'    => $request->phone,
            'mobile'   => $request->mobile,
            'zipcode'  => $request->zipcode,
            'city'     => $request->city['townName'],
            'province' => $request->province['stateName'],
            'address'  => $request->address,
        ];
        $address = $setting->address;

        if (is_null($address)) {
            $setting->address()->create($addressData);
        } else {
            $address->update($addressData);
        }

        return response()->json([
            'message' => 'اطلاعات فروشگاه با موفقیت ذخیره شد.'
        ]);
    }

    public function getMarketInfo()
    {
        $setting = Setting::first();
        $address = MarketAddress::first();

        return response()->json([
            'setting' => $setting,
            'address' => $address,
        ]);
    }
}
