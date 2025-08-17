@extends('layouts.app')

@section('title', 'Welcome to Concertly')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-screen flex items-center justify-center"
             style="background-image: url('https://images.unsplash.com/photo-1507874457470-272b3c8d8ee2?auto=format&fit=crop&w=1470&q=80');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative z-10 text-center text-white px-6">
            <h2 class="text-4xl md:text-6xl font-bold mb-4">Experience the Best Concerts</h2>
            <p class="text-lg md:text-2xl mb-6">Join thousands of music lovers at our upcoming events</p>
            <a href="#events" class="bg-indigo-600 px-6 py-3 rounded-lg text-lg font-semibold hover:bg-indigo-700">
                See Upcoming Events
            </a>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section id="events" class="py-20 container mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12">Upcoming Concerts</h3>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach ([
                ['title' => 'Rock Night Festival', 'date' => 'Saturday, Sept 21 • Jakarta', 'img' => 'https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=800&q=80'],
                ['title' => 'Jazz in The Park', 'date' => 'Sunday, Oct 15 • Bandung', 'img' => 'https://images.unsplash.com/photo-1521334884684-d80222895322?auto=format&fit=crop&w=800&q=80'],
                ['title' => 'EDM Night Party', 'date' => 'Friday, Nov 10 • Bali', 'img' => 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=800&q=80']
            ] as $event)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ $event['img'] }}" alt="{{ $event['title'] }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2">{{ $event['title'] }}</h4>
                        <p class="text-gray-600 mb-4">{{ $event['date'] }}</p>
                        <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Book Now</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- About -->
    <section id="about" class="py-20 bg-gray-100">
        <div class="container mx-auto px-6 md:flex items-center gap-12">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <img src="https://images.unsplash.com/photo-1518972559570-7cc1309f3229?auto=format&fit=crop&w=900&q=80" alt="About" class="rounded-lg shadow-lg">
            </div>
            <div class="md:w-1/2">
                <h3 class="text-3xl font-bold mb-6">About Us</h3>
                <p class="text-gray-700 mb-4">We are passionate event organizers bringing unforgettable music experiences across Indonesia.</p>
                <p class="text-gray-700">Looking to showcase your brand or product? Become a tenant at our events and reach thousands of attendees.</p>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="py-20 container mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12">Get In Touch</h3>
        <form action="#" method="POST" class="max-w-2xl mx-auto space-y-6">
            <div>
                <label class="block text-gray-700 mb-2">Name</label>
                <input type="text" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Email</label>
                <input type="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Message</label>
                <textarea rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">Send Message</button>
        </form>
    </section>

@endsection
