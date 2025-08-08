@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-6xl">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Top Section: Image and Product Details -->
        <div class="flex flex-col md:flex-row gap-8 p-6">
            <!-- Left Column: Product Image (50% width) -->
            <div class="w-full md:w-1/2 flex items-center justify-center">
                <div class="w-full max-w-md h-80 lg:h-96 bg-gray-50 flex items-center justify-center p-4 rounded-lg border">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->product_name }}"
                             class="w-full h-full object-contain" />
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-lg">
                            <span class="text-gray-500 text-lg">No Image Available</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Product Details (50% width) -->
            <div class="w-full md:w-1/2 space-y-6">
                <!-- Product Title -->
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-blue-600 leading-tight">
                        {{ $product->product_name }}
                    </h1>
                </div>

                <!-- Pricing and Availability -->
                <div class="space-y-3">
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-lg font-semibold text-gray-900">Price: {{ number_format($product->price, 2) }} <span class="text-2xl font-bold">৳</span></span>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-gray-800">Status: <span class="text-green-600 font-medium">In Stock</span></span>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-gray-800">Product Code: <span class="font-medium">{{ $product->id }}</span></span>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-gray-800">Category: <span class="font-medium">{{ $product->category }}</span></span>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-gray-800">Location: <span class="font-medium">{{ $product->location }}</span></span>
                    </div>
                </div>

                <!-- Payment Options -->
                <div class="border-t pt-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Payment Options</h3>
                    <div class="text-gray-700 space-y-1">
                        <div>• Cash on Delivery</div>
                        <div>• Credit Card</div>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                @auth
                    @if(!auth()->user()->isAdmin())
                        <div class="pt-4">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth

            </div>
        </div>

        <!-- Bottom Section: Full Description (Full Width) -->
        <div class="border-t border-gray-200">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Product Description</h2>
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed text-lg mb-6">
                        This is a detailed description of the product. You can extend this field by adding a `description` column to your products table and rendering it here.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Product Features</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• Premium quality materials</li>
                                <li>• Reliable performance</li>
                                <li>• User-friendly design</li>
                                <li>• Long-lasting durability</li>
                                <li>• Easy to use and maintain</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Care Instructions</h3>
                            <div class="text-gray-700 space-y-2">
                                <p>• Handle with care</p>
                                <p>• Keep in a dry place</p>
                                <p>• Avoid extreme temperatures</p>
                                <p>• Clean regularly as needed</p>
                                <p>• Follow manufacturer guidelines</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Additional Information</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Our products are designed with quality and functionality in mind. They offer excellent value for money and is built to meet your needs. Whether for personal use, business, or as a gift, this product delivers reliable performance and satisfaction. Each item is carefully inspected to ensure it meets our quality standards before reaching our customers.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
