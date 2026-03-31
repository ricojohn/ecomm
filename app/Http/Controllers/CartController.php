<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product')->first();

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        if (! auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in to add items to your cart.',
                'cart_count' => 0,
            ], 401);
        }

        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['sometimes', 'integer', 'min:1'],
        ]);

        $product  = Product::findOrFail($request->product_id);
        $quantity = (int) $request->input('quantity', 1);

        if (! $product->isAvailable()) {
            return response()->json([
                'success'    => false,
                'message'    => 'This product is currently unavailable.',
                'cart_count' => $this->getCartCount(),
            ]);
        }

        $cart = auth()->user()->cart()->firstOrCreate([]);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        $newQuantity = $cartItem ? $cartItem->quantity + $quantity : $quantity;

        if ($newQuantity > $product->stock) {
            return response()->json([
                'success'    => false,
                'message'    => "Only {$product->stock} unit(s) available in stock.",
                'cart_count' => $this->getCartCount(),
            ]);
        }

        if ($cartItem) {
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
            ]);
        }

        return response()->json([
            'success'    => true,
            'message'    => "{$product->name} added to cart.",
            'cart_count' => $this->getCartCount(),
        ]);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($request->quantity > $cartItem->product->stock) {
            return back()->withErrors(['quantity' => "Only {$cartItem->product->stock} unit(s) in stock."]);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    private function authorizeCartItem(CartItem $cartItem): void
    {
        abort_unless(
            auth()->user()->cart && $cartItem->cart_id === auth()->user()->cart->id,
            403
        );
    }

    private function getCartCount(): int
    {
        $cart = auth()->user()->cart()->with('items')->first();

        return $cart ? $cart->items->count() : 0;
    }
}
