<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();
            
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    

    public function addToCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $product = Product::findOrFail($id);
        
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function updateQuantity(Request $request, $cartItemId)
    {
        $cartItem = Cart::findOrFail($cartItemId);
        
        if ($request->action === 'increment') {
            $cartItem->increment('quantity');
        } else if ($request->action === 'decrement') {
            if ($cartItem->quantity <= 1) {
                // Delete the cart item
                $cartItem->delete();
                
                return response()->json([
                    'redirect' => '/',
                    'message' => 'Item removed from cart'
                ]);
            }
            $cartItem->decrement('quantity');
        }

        $cartItem->refresh();
        
        return response()->json([
            'quantity' => $cartItem->quantity,
            'total' => $cartItem->quantity * $cartItem->product->price
        ]);
    }

    public function remove($cartItemId)
    {
        Cart::where('id', $cartItemId)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }
} 