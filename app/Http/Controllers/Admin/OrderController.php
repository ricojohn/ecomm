<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
    }

    public function index()
    {
        $this->authorizeAdmin();

        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorizeAdmin();

        $order->load('user', 'items');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeAdmin();

        $request->validate([
            'status' => ['required', 'in:verified,paid,ready_for_pickup'],
        ]);

        $order->update(['status' => $request->status]);

        $label = ucfirst(str_replace('_', ' ', $request->status));

        Mail::to($order->user->email)->send(new OrderStatusUpdated($order));

        return back()->with('success', "Order status updated to {$label}.");
    }
}
