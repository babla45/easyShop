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
            if ($request->ajax()) {
                return response()->json(['error' => 'Please login to add items to cart'], 401);
            }
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

        // Get updated cart count
        $cartCount = Auth::user()->getCartCount();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => $cartCount
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
            // Prevent quantity from going below 1
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                // Return error message if trying to decrement below 1
                return response()->json([
                    'error' => 'Quantity cannot be reduced below 1',
                    'quantity' => $cartItem->quantity,
                    'total' => $cartItem->quantity * $cartItem->product->price
                ], 400);
            }
        }

        $cartItem->refresh();

        // Get updated cart count
        $cartCount = Auth::user()->getCartCount();

        return response()->json([
            'quantity' => $cartItem->quantity,
            'total' => $cartItem->quantity * $cartItem->product->price,
            'cartCount' => $cartCount
        ]);
    }

    public function remove($cartItemId)
    {
        Cart::where('id', $cartItemId)
            ->where('user_id', Auth::id())
            ->delete();

        // Get updated cart count
        $cartCount = Auth::user()->getCartCount();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
