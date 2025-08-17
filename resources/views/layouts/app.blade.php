
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Concertly')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('jquery.seat-charts.css') }}" />
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Navbar -->
    <header class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600">Concertly</a>
            <nav class="hidden md:flex space-x-6">
                <a href="{{ url('/') }}#events" class="hover:text-indigo-600">Events</a>
                <a href="{{ url('/') }}#about" class="hover:text-indigo-600">About</a>
                <a href="{{ url('/') }}#contact" class="hover:text-indigo-600">Contact</a>
            </nav>
            <a href="{{ route('event') }}"
               class="ml-6 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
               Book a Tenant
            </a>
        </div>
    </header>

    <!-- Page Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center mt-20">
        <p>© {{ date('Y') }} Concertly. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('jquery.seat-charts.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
