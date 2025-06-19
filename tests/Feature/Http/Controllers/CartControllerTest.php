<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_checkout_without_payment_method()
    {
        $response = $this->post('/api/checkout', [
        ]);
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_checkout_with_invalid_payment_method()
    {
        $response = $this->post('/api/checkout', [
            'method' => 'stripe',
            'items' => [
                [
                    'name' => 'Shirt',
                    'unit_price' => 29.91,
                    'quantity' => 2
                ],
            ]
        ]);
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_checkout_pix_without_key()
    {
        $response = $this->post('/api/checkout', [
            'method' => 'pix',
            'items' => [
                [
                    'name' => 'Shirt',
                    'unit_price' => 29.91,
                    'quantity' => 2
                ],
            ]
        ]);
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_checkout_pix_success()
    {
        $response = $this->post('/api/checkout', [
            'method' => 'pix',
            'pix_key' => 'james@xmen.org',
            'items' => [
                [
                    'name' => 'Shirt',
                    'unit_price' => 50,
                    'quantity' => 2
                ],
            ]
        ]);
        $response->assertStatus(201);
        $this->assertEquals(90, $response->json('total'));
    }

    /**
     * @return void
     */
    public function test_checkout_credit_card_without_card_holder_name()
    {
        $response = $this->post('/api/checkout', [
            'method' => 'credit_card',
            'card_number' => '9112311334411221',
            'card_expiration' => '01/32',
            'card_cvv' => '123',
            'installments' => 10,
            'items' => [
                [
                    'name' => 'Shirt',
                    'unit_price' => 29.91,
                    'quantity' => 2
                ],
            ]
        ]);
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_checkout_credit_card_without_card_number()
    {
        $response = $this->post('/api/checkout', [
            'method' => 'credit_card',
            'card_holder_name' => 'James Howlett',
            'card_expiration' => '01/32',
            'card_cvv' => '123',
            'installments' => 10,
            'items' => [
                [
                    'name' => 'Shirt',
                    'unit_price' => 29.91,
                    'quantity' => 2
                ],
            ]
        ]);
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_checkout_credit_card_without_card_expiration()
    {
        $response = $this->post('/api/checkout', [
            'method' => 'credit_card',
            'card_holder_name' => 'James Howlett',
            'card_number' => '9112311334411221',
            'card_cvv' => '123',
            'installments' => 10,
            'items' => [
                [
                    'name' => 'Shirt',
                    'unit_price' => 29.91,
                    'quantity' => 2
                ],
            ]
        ]);
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_checkout_credit_card_without_card_cvv()
    {
        $response = $this->post('/api/checkout', [
            'method' => 'credit_card',
            'card_holder_name' => 'James Howlett',
            'card_number' => '9112311334411221',
            'card_expiration' => '01/32',
            'installments' => 10,
            'items' => [
                [
                    'name' => 'Shirt',
                    'unit_price' => 29.91,
                    'quantity' => 2
                ],
            ]
        ]);
        $response->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_checkout_credit_card_one_installments_success()
    {
        $response = $this->post('/api/checkout', [
            'method' => 'credit_card',
            'card_holder_name' => 'James Howlett',
            'card_number' => '9112311334411221',
            'card_expiration' => '01/32',
            'card_cvv' => '123',
            'installments' => 1,
            'items' => [
                [
                    'name' => 'Shirt',
                    'unit_price' => 50,
                    'quantity' => 2
                ],
            ]
        ]);
        $response->assertStatus(201);
        $this->assertEquals(90, $response->json('total'));
    }

    /**
     * @return void
     */
    public function test_checkout_credit_card_ten_installments_success()
    {
        $response = $this->post('/api/checkout', [
            'method' => 'credit_card',
            'card_holder_name' => 'James Howlett',
            'card_number' => '9112311334411221',
            'card_expiration' => '01/32',
            'card_cvv' => '123',
            'installments' => 10,
            'items' => [
                [
                    'name' => 'Shirt',
                    'unit_price' => 50,
                    'quantity' => 2
                ],
            ]
        ]);
        $response->assertStatus(201);
        $this->assertEquals(110.46, $response->json('total'));
    }
}
