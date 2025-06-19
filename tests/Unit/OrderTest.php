<?php

namespace Tests\Unit;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_create_order()
    {
        $order = new Order();
        $this->assertInstanceOf(Order::class, $order);
        $this->assertInstanceOf(Collection::class, $order->items);
    }
}
