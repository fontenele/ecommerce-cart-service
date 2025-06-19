<?php

namespace App\Domain;

class PixPaymentStrategy implements PaymentStrategyInterface
{
    public function calculateTotal(float $amount, int $installments = 1): float
    {
        $percent = 10;
        $amountStr = number_format($amount, 2, '.', '');
        $discount = bcmul($amountStr, bcdiv($percent, '100', 4), 2);
        return (float) bcsub($amountStr, $discount, 2);
    }
}
