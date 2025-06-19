<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use App\Services\PaymentService;
use App\Domain\PixPaymentStrategy;
use App\Domain\CreditCardPaymentStrategy;

class PaymentServiceTest extends TestCase
{
    public function test_pix_payment_applies_10_percent_discount()
    {
        $service = new PaymentService(new PixPaymentStrategy());
        $this->assertEquals(90.0, $service->getTotal(100));
    }

    public function test_credit_card_payment_applies_10_percent_discount()
    {
        $service = new PaymentService(new CreditCardPaymentStrategy());
        $this->assertEquals(90.0, $service->getTotal(100));
    }
}
