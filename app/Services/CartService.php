<?php

namespace App\Services;

class CartService
{
    public function calculateSubtotal(array $items): float
    {
        return collect($items)->sum(function ($item) {
            return $item['unit_price'] * $item['quantity'];
        });
    }
}
