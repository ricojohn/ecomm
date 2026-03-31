<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTravelerRequest;
use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\TravelerVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function travelerForm()
    {
        $cart = auth()->user()->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.traveler', compact('cart'));
    }

    public function verifyTraveler(StoreTravelerRequest $request, TravelerVerificationService $service)
    {
        $data   = $request->validated();
        $result = $service->verify($data);

        if (! $result['eligible']) {
            return back()->withInput()->with('error', $result['message']);
        }

        session([
            'traveler'       => $data,
            'checkout_token' => (string) Str::uuid(),
        ]);

        return redirect()->route('checkout.confirm');
    }

    public function confirm()
    {
        if (! session()->has('traveler') || ! session()->has('checkout_token')) {
            return redirect()->route('checkout.traveler')->with('error', 'Please complete traveler verification first.');
        }

        $cart     = auth()->user()->cart()->with('items.product')->first();
        $traveler = session('traveler');

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.confirm', compact('cart', 'traveler'));
    }

    public function placeOrder(Request $request)
    {
        $traveler = session('traveler');
        $token    = session('checkout_token');

        if (! $traveler || ! $token) {
            return redirect()->route('checkout.traveler')->with('error', 'Session expired. Please verify traveler information again.');
        }

        // Prevent duplicate submission
        if (Order::where('checkout_token', $token)->exists()) {
            session()->forget(['traveler', 'checkout_token']);
            return redirect()->route('orders.index')->with('error', 'This order has already been placed.');
        }

        $user = auth()->user();
        $cart = $user->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            $order = DB::transaction(function () use ($user, $cart, $traveler, $token) {
                // Lock cart items to prevent race conditions
                $cartItems = $cart->items()->lockForUpdate()->with('product')->get();

                // Validate stock for each item
                foreach ($cartItems as $item) {
                    if ($item->product->stock < $item->quantity) {
                        throw new \Exception("Insufficient stock for {$item->product->name}. Only {$item->product->stock} unit(s) left.");
                    }
                }

                $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);

                // Create order
                $order = Order::create([
                    'user_id'            => $user->id,
                    'order_number'       => 'ORD-' . strtoupper(Str::random(8)),
                    'status'             => 'pending',
                    'subtotal'           => $subtotal,
                    'total'              => $subtotal,
                    'checkout_token'     => $token,
                    'traveler_full_name' => $traveler['full_name'],
                    'passport_number'    => $traveler['passport_number'],
                    'nationality'        => $traveler['nationality'],
                    'flight_number'      => $traveler['flight_number'],
                    'departure_date'     => $traveler['departure_date'],
                    'destination'        => $traveler['destination'],
                    'eligibility_status' => 'verified',
                    'eligibility_message'=> 'Traveler verified. Eligible for duty-free purchase.',
                ]);

                // Create order items and deduct stock
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id'     => $order->id,
                        'product_id'   => $item->product->id,
                        'sku'          => $item->product->sku,
                        'product_name' => $item->product->name,
                        'price'        => $item->product->price,
                        'quantity'     => $item->quantity,
                        'line_total'   => $item->product->price * $item->quantity,
                    ]);

                    $item->product->decrement('stock', $item->quantity);
                }

                // Clear cart
                $cart->items()->delete();
                $cart->delete();

                return $order;
            });

            session()->forget(['traveler', 'checkout_token']);

            Mail::to($user->email)->send(new OrderPlaced($order));

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
