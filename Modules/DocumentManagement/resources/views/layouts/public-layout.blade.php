<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management</title>

    <!-- Tailwind CSS CDN (You can replace this with your own build) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-900">
    <!-- Header Section -->
    <header class="bg-gradient-to-r from-green-500 to-green-700 text-white py-8 shadow-lg">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-extrabold">Document Management System</h1>
            <p class="text-lg mt-2">Explore documents shared by various divisions</p>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="container mx-auto my-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            @yield('content') <!-- This is where the page content will be inserted -->
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="bg-white border-t border-gray-200 text-center py-6">
        <p class="text-sm text-gray-500">© 2025 Document Management System. All rights reserved.</p>
    </footer>
</body>

</html>
