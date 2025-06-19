<?php

namespace App\Domain;

interface PaymentStrategyInterface
{
    public function calculateTotal(float $amount, int $installments = 1): float;
}
