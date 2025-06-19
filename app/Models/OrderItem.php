<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: "OrderItem",
    description: "Order Items",
    properties: [
        new OAT\Property(property: "order_id", type: "number"),
        new OAT\Property(property: "name", type: "string"),
        new OAT\Property(property: "unit_price", type: "number"),
        new OAT\Property(property: "quantity", type: "number"),
    ]
)]
class OrderItem extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_id',
        'name',
        'unit_price',
        'quantity',
    ];
}
