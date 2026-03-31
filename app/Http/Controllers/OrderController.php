<?php

namespace App\Http\Controllers;

use App\Mail\OrderCancelled;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items');

        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'pending', 422, 'Only pending orders can be cancelled.');

        DB::transaction(function () use ($order) {
            $order->load('items.product');

            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelled']);
        });

        Mail::to(auth()->user()->email)->send(new OrderCancelled($order));

        return redirect()->route('orders.index')->with('success', 'Order cancelled and stock restored.');
    }
}
