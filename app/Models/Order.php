<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: "Order",
    description: "Orders",
    properties: [
        new OAT\Property(property: "method", type: "string"),
        new OAT\Property(property: "card_holder_name", type: "string"),
        new OAT\Property(property: "card_number", type: "string"),
        new OAT\Property(property: "card_expiration", type: "string"),
        new OAT\Property(property: "card_cvv", type: "string"),
        new OAT\Property(property: "pix_key", type: "string"),
        new OAT\Property(property: "installments", type: "number"),
        new OAT\Property(property: "total", type: "number"),
        new OAT\Property(property: "items", type: "array", items: new OAT\Items(ref: OrderItem::class)),
    ]
)]
class Order extends Model
{
    protected $fillable = [
        'method',
        'card_holder_name',
        'card_number',
        'card_expiration',
        'card_cvv',
        'pix_key',
        'installments',
        'total',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
