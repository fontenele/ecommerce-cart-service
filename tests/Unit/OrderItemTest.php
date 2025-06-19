<?php

namespace Tests\Unit;

use App\Models\OrderItem;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    public function test_create_order_item()
    {
        $orderItem = new OrderItem();
        $this->assertInstanceOf(OrderItem::class, $orderItem);
    }
}
