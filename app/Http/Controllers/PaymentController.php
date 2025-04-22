<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));
        $cart = session()->get('cart', []);
        $lineItems = [];

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => [$item['image']],
                    ],
                    'unit_amount' => $item['price'] * 100,
                ],
                'quantity' => $item['quantity'],
            ];
        }


        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect($session->url, 303);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $orderId = 'ORD-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

        session(['order_id' => $orderId]);
        
        session()->forget('cart');

        return view('checkout.success', compact('sessionId', 'orderId'));
    }

    public function cancel()
    {
        return view('checkout.cancel')->with('error', 'Payment was canceled.');
    }
}
