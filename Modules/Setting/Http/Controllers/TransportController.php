<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TransportController extends Controller
{
    public function loginPostex()
    {
        $response = Http::asForm()->post('https://postex.ir/api/login', [
            'Username' => "09172138376",
            'Password' => 'amir1374msj',
        ]);

        $token = json_decode($response->body(), true)['Token'];
        Cache::put("postexToken", $token);
    }

    public function isTokenExpire()
    {
        $response = Http::asForm()->post('https://postex.ir/api/IsTokenExpire', [
            'data' => Cache::get("postexToken")
        ]);

        return json_decode($response->getBody(), true)['IsValid'];
    }

    public function getListOfStates()
    {

        if (is_null(Cache::get("postexToken")) || $this->isTokenExpire()) {
            $this->loginPostex();
        }

        $token = Cache::get("postexToken");


        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'token' => $token
        ])->get('https://postex.ir/api/state/getState');

        return response()->json([
            'provinces' => json_decode($response->body())
        ]);
        // dd(json_decode($response->body()));
    }

    public function getListOfTowns($stateId)
    {
        if (is_null(Cache::get("postexToken")) || $this->isTokenExpire()) {
            $this->loginPostex();
        }
        $token = Cache::get("postexToken");

        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'token' => $token
        ])->get('https://postex.ir/api/town/getTownsByStateId', [
            'stateId' => $stateId
        ]);

        // 412
        return response()->json([
            "cities" => json_decode($response->body())
        ]);
        // dd(json_decode($response->body()));
    }

    public function getListOfServices()
    {

        if (is_null(Cache::get("postexToken")) || $this->isTokenExpire()) {
            $this->loginPostex();
        }
        $token = Cache::get("postexToken");

        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'token' => $token
        ])->get('https://postex.ir/api/getServiceList');

        // پیشتاز 723
        dd(json_decode($response->body()));
    }

    public function getListOfInsurances()
    {

        if (is_null(Cache::get("postexToken")) || $this->isTokenExpire()) {
            $this->loginPostex();
        }
        $token = Cache::get("postexToken");

        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'token' => $token
        ])->get('https://postex.ir/api/getInsuranceList', [
            'serviceId' => 723,
        ]);

        dd(json_decode($response->body(), true)['data']);
        // "Id" => 19453
        // "Name" => "* انتخاب بیمه ضروری است *"
        // "Id" => 19454
        // "Name" => "غرامت تا سقف 300 هزار تومان"
    }

    public function getPriceInfo()
    {

        if (is_null(Cache::get("postexToken")) || $this->isTokenExpire()) {
            $this->loginPostex();
        }
        $token = Cache::get("postexToken");

        $data = [
            'serviceId' => 723, //723
            'weight' => 100,
            'insuranceName' => "غرامت تا سقف 300 هزار تومان",
            'packingDimension' => [
                'length' => 15,
                'width' => 20,
                'height' => 20,
            ],
            'senderCityId' => 585,
            'receiverCityId' => 412,
            'goodsValue' => 15000000,
            'printBill' => false,
            'needCartoon' => true,
            'pringLogo' => false,
            'isCod'  => false,
            'sendSms'  => false,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'token' => $token
        ])->post('https://postex.ir/api/newgetprice', $data);

        // پیشتاز 723
        dd(json_decode($response->getBody()));
    }
}
