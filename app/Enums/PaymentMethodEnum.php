<?php

namespace App\Enums;

#[\OpenApi\Attributes\Schema(type: 'string')]
enum PaymentMethodEnum: string
{
    case PIX = 'pix';
    case CREDIT_CARD = 'credit_card';
}
