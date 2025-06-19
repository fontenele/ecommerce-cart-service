<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethodEnum;
use App\Http\Controllers\Docs\CheckoutControllerInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\PaymentService;
use Illuminate\Validation\Rule;
use App\Domain\{PixPaymentStrategy, CreditCardPaymentStrategy};

class CheckoutController extends Controller implements CheckoutControllerInterface
{
    public function checkout(Request $request, CartService $cartService)
    {
        $method = $request->input('method');
        $installments = $request->input('installments', 1);
        $cardHolderName = $request->input('card_holder_name');
        $cardNumber = $request->input('card_number');
        $cardExp = $request->input('card_expiration');
        $cardCvv = $request->input('card_cvv');
        $pixKey = $request->input('pix_key');
        $items = $request->input('items', []);

        $request->validate([
            'method' => ['required', Rule::enum(PaymentMethodEnum::class)],
            'items' => ['required', 'array'],
            'pix_key' => ['required_if:method,pix'],
            'card_holder_name' => ['required_if:method,credit_card', 'required_if:method,installment'],
            'card_number' => ['required_if:method,credit_card', 'required_if:method,installment'],
            'card_expiration' => ['required_if:method,credit_card', 'required_if:method,installment'],
            'card_cvv' => ['required_if:method,credit_card', 'required_if:method,installment'],
            'installments' => ['required_if:method,installment'],
        ]);

        $subTotal = $cartService->calculateSubtotal($items);

        $strategy = match (PaymentMethodEnum::from($method)) {
            PaymentMethodEnum::PIX => new PixPaymentStrategy(),
            PaymentMethodEnum::CREDIT_CARD => new CreditCardPaymentStrategy(),
        };

        $paymentService = new PaymentService($strategy);
        $total = $paymentService->getTotal($subTotal, $installments);

        return Order::create([
            'method' => $method,
            'card_holder_name' => $cardHolderName,
            'card_number' => $cardNumber,
            'card_expiration' => $cardExp,
            'card_cvv' => $cardCvv,
            'pix_key' => $pixKey,
            'installments' => $installments,
            'total' => $total,
            'items' => $items
        ]);
    }
}
