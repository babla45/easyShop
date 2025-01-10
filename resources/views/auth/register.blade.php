<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 text-center">User Registration</h2>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('register.user') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-600 mb-2">Name</label>
                <input type="text" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-600 mb-2">Phone</label>
                <input type="text" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-600 mb-2">Location</label>
                <input type="text" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" id="location" name="location" placeholder="Enter your location" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-600 mb-2">Email</label>
                <input type="email" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-600 mb-2">Password</label>
                <input type="password" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-600 mb-2">Confirm Password</label>
                <input type="password" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600">Register</button>
        </form>
    </div>
</body>
</html>
