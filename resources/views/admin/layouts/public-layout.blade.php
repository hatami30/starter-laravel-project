<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management</title>

    <!-- Add Tailwind CSS (or any other CSS framework) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Optional: Add your own custom styles here -->
    <style>
        .btn-primary {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-gray-100">

    <header class="bg-green-600 p-4 text-white text-center">
        <h1 class="text-3xl font-semibold">Document Management System</h1>
        <p>Explore documents shared by various divisions</p>
    </header>

    <div class="container mx-auto mt-10 px-4">
        @yield('content')
    </div>

    <footer class="bg-gray-200 text-center py-4 mt-10">
        <p class="text-sm text-gray-600">© 2025 Document Management System</p>
    </footer>

</body>

</html>
