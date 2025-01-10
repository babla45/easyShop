<form action="{{ route('cart.add', $product->id) }}" method="POST">
    @csrf
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Add to Cart
    </button>
</form> 