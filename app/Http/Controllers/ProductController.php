<?php
// app/Http/Controllers/ProductController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(50);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
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
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $product->update([
            'product_name' => $request->product_name,
            'category' => $request->category,
            'price' => $request->price,
            'location' => $request->location,
            'image' => $imagePath,
        ]);

        return redirect('/')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
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
