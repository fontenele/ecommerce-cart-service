<?php

namespace App\Services;

use App\Domain\PaymentStrategyInterface;

readonly class PaymentService
{
    public function __construct(private PaymentStrategyInterface $strategy)
    {
    }

    public function getTotal(float $amount, int $installments = 1): float
    {
        return $this->strategy->calculateTotal($amount, $installments);
    }
}
