<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        
        $product = Product::findOrFail($productId);
        
        if ($product->stock <= 0) {
            return back()->with('error', 'This product is out of stock.');
        }
        
        if ($product->stock < $quantity) {
            return back()->with('error', 'The requested quantity is not available.');
        }

        if (!session()->has('cart')) {
            session()->put('cart', []);
        }
        
        $cart = session()->get('cart');
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        
        return back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (!session()->has('cart') || !isset(session('cart')[$productId])) {
            return back()->with('error', 'Product not found in cart.');
        }

        $cart = session()->get('cart');

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated successfully!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->input('product_id');

        if (!session()->has('cart') || !isset(session('cart')[$productId])) {
            return back()->with('error', 'Product not found in cart.');
        }

        $cart = session()->get('cart');
        unset($cart[$productId]);

        session()->put('cart', $cart);

        return back()->with('success', 'Product removed from cart successfully!');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully!');
    }
}
