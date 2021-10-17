<?php

use Illuminate\Support\Facades\Log;
use Modules\Discount\Entities\Discount;

/**
 * calcDiscount
 *
 * @param  mixed $newPrice  is price get from user
 * @param  mixed $oldPrice is price get from databse 
 * @param  mixed $amount 
 * @param  mixed $measure Specified type of  calculated discount
 * @return void
 */
function calculateDiscount($newPrice, $oldPrice, $amount, $measure = null)
{
    if ($measure === 'percent') {
        $discount = $newPrice * $amount / 100;
        $price = $newPrice - $discount;
    } else {
        $discount = $newPrice > $amount ? $amount : 0;
        $price = $newPrice - $discount;
    }

    return [
        'price' => $price,
        'discount' => $discount
    ];
}

function calcTax($price, $tax_status)
{

    return  $tax_status ? $price * 1.09 : $price;
}

function changeFinalPrice($oldInventory, $inventory, $tax_status)
{

    $discount = 0;
    $price = $inventory['price'];
    $discounts = Discount::where('status', 1)->get();
    foreach ($discounts as $discount) {
        if ($discount->select_all === 1) {
            $result = calculateDiscount($inventory['price'], $oldInventory->price, $discount->amount, $discount->measure);
            $price = $result['price'];
            $discount = $result['discount'];
        } elseif (in_array($oldInventory->product_id, json_decode($discount->selected))) {
            $result = calculateDiscount($inventory['price'], $oldInventory->price, $discount->amount, $discount->measure);
            $price = $result['price'];
            $discount = $result['discount'];
        }
    }
   
    $final_price = calcTax($price, $tax_status);
  
    return [
        'final_price' => $final_price,
        'discount' => $discount,
    ];
}
