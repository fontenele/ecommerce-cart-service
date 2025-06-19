<?php

namespace App\Http\Controllers\Docs;

use App\Enums\PaymentMethodEnum;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

#[OAT\Info(
    version: "1.0",
    description: "Cart Service API documentation",
    title: "Cart Service",
    attachables: [new OAT\Attachable()]
)]
#[OAT\Contact(name: "Guilherme Fontenele", url: "https://github.com/fontenele", email: "guilherme@fontenele.net")]
#[OAT\Server(url: "http://localhost:8000", description: "CartService")]
interface CheckoutControllerInterface
{
    #[OAT\Post(
        path: '/api/checkout',
        operationId: 'checkout',
        description: "Checkout Cart",
        summary: "Checkout Cart",
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\MediaType(
                mediaType: "application/json",
                schema: new OAT\Schema(
                    required: ['method'],
                    properties: [
                        new OAT\Property(property: "method", description: "Payment Method", ref: PaymentMethodEnum::class, example: "credit_card"),
                        new OAT\Property(property: "card_holder_name", description: "Credit Card Holder Name", type: "string", example: "James Howlett", nullable: true),
                        new OAT\Property(property: "card_number", description: "Credit Card Number", type: "string", example: "9112311334411221", nullable: true),
                        new OAT\Property(property: "card_expiration", description: "Credit Card Date Exp", type: "string", example: "01/32", nullable: true),
                        new OAT\Property(property: "card_cvv", description: "Credit Card CVV", type: "string", example: "123", nullable: true),
                        new OAT\Property(property: "pix_key", description: "PIX Key", type: "string", example: "james@xmen.org", nullable: true),
                        new OAT\Property(property: "installments", description: "Installments", type: "number", example: 1, nullable: true),
                        new OAT\Property(property: "items", description: "items", type: "array", example: [
                            ['name' => 'Shirt', 'unit_price' => 29.99, 'quantity' => 2]
                        ], items: new OAT\Items(
                            properties: [
                                new OAT\Property(property: "name", description: "Product Name", type: "string"),
                                new OAT\Property(property: "unit_price", description: "Unit Price", type: "number"),
                                new OAT\Property(property: "quantity", description: "Quantity", type: "number"),
                            ],
                        )),
                    ],
                )
            )
        ),
        tags: ["Checkout Controller"],
    )]
    #[OAT\Response(response: '201', description: 'Order', content: new OAT\JsonContent(ref: Order::class))]
    #[OAT\Response(response: '404', description: 'Not found', content: new OAT\JsonContent(
        properties: [new OAT\Property(property: "message", type: "string", example: "Resource not found")]
    ))]
    public function checkout(Request $request, CartService $cartService);
}
