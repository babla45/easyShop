<?php


// app/Http/Controllers/ProductController.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function orderProduct($id)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect to the login page if not logged in
            return redirect()->route('login', ['redirect_to' => route('order.product', $id)]);
        }

        // Fetch the product by ID
        $product = Product::findOrFail($id);

        // Return the view with product details
        return view('order.product', compact('product'));
    }
    public function index()
    {
        $products = Product::paginate(50);
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('index')
                ->with('error', 'Access denied. Only administrators can add products.');
        }

        return view('products.create');
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('index')
                ->with('error', 'Access denied. Only administrators can add products.');
        }

        $request->validate([
            'product_name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'location' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : null;

        Product::create([
            'product_name' => $request->product_name,
            'category' => $request->category,
            'price' => $request->price,
            'location' => $request->location,
            'image' => $imagePath,
        ]);

        return redirect('/')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('index')
                ->with('error', 'Access denied. Only administrators can edit products.');
        }
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('index')
                ->with('error', 'Access denied. Only administrators can update products.');
        }

        $product = Product::findOrFail($id);
        
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
        ]);

        $product->update([
            'product_name' => $request->product_name,
            'category' => $request->category,
            'price' => $request->price,
            'location' => $request->location,
        ]);

        // Redirect to home page with success message
        return redirect()->route('index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('index')
                ->with('error', 'Access denied. Only administrators can delete products.');
        }
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/')->with('success', 'Product deleted successfully.');
    }

    public function search2(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('product_name', 'like', "%$query%")
            ->orWhere('category', 'like', "%$query%")
            ->orWhere('location', 'like', "%$query%")
            ->paginate(50);

        return view('products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $searchBy = $request->input('search_by'); // 'name', 'category', or 'location'
        $query = $request->input('query');

        $products = Product::query();

        // Apply search based on the selected dropdown option
        if ($searchBy === 'name') {
            $products = $products->where('product_name', 'like', '%' . $query . '%');
        } elseif ($searchBy === 'category') {
            $products = $products->where('category', 'like', '%' . $query . '%');
        } elseif ($searchBy === 'location') {
            $products = $products->where('location', 'like', '%' . $query . '%');
        }

        $products = $products->paginate(50);

        return view('products.index', compact('products'));
    }


}
// app/Http/Controllers/ProductController.php
