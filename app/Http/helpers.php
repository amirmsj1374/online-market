<?php

// helper functions

function calculatePriceWithTaxAndDiscount($newPrice, $oldPrice, $amount, $measure = null)
{
    if ($measure === 'percent') {
        $price = $newPrice * (100 - $amount) / 100;
    } else {
        $price = $newPrice > $oldPrice ? $newPrice : $oldPrice - $newPrice;
    }

    return $price;
}
