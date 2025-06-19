<?php

namespace App\Domain;

class CreditCardPaymentStrategy implements PaymentStrategyInterface
{
    public function calculateTotal(float $amount, int $installments = 1): float
    {
        $amountStr = number_format($amount, 2, '.', '');

        if ($installments === 1) {
            $discount = bcmul($amountStr, bcdiv('10', '100', 4), 2);
            return (float) bcsub($amountStr, $discount, 2);
        }

        $interestRate = '0.01';
        $base = bcadd('1', $interestRate, 4);

        $n = max(2, min($installments, 12));

        $factor = '1';
        for ($i = 0; $i < $n; $i++) {
            $factor = bcmul($factor, $base, 10);
        }

        return (float) bcmul($amountStr, $factor, 2);
    }
}
