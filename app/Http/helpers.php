<?php

// helper functions

// /**
//  * calcDiscount
//  *
//  * @param  mixed $newPrice  is price get from user
//  * @param  mixed $oldPrice is price get from databse 
//  * @param  mixed $amount 
//  * @param  mixed $measure Specified type of  calculated discount
//  * @return void
//  */
// function calculateDiscount($newPrice, $oldPrice, $amount, $measure = null)
// {
//     if ($measure === 'percent') {
//         $discount = $newPrice * $amount / 100;
//         $price = $newPrice - $discount;
//     } else {
//         $discount = $newPrice > $amount ? $amount : 0;
//         $price = $newPrice - $discount;
//     }

//     return [
//         'price' => $price,
//         'discount' => $discount
//     ];
// }
