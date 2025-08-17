@extends('layouts.app')

@section('title', 'Events')

@section('content')
<section class="container mx-auto py-20 px-6">
    <h2 class="text-3xl font-bold mb-6">Choose Your Tenant Spot</h2>
    <p class="text-gray-600 mb-8">Click on an available spot to reserve it.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
            <div class="p-6 border rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold">{{ $event->acara }}</h3>
                <p class="text-gray-600 text-sm mb-2">{{ $event->lokasi }}</p>
                <p class="text-gray-500 text-sm mb-4">📅 {{ $event->tanggal_acara->format('d M Y') }}</p>
                <a href="{{ route('event.show', $event->id) }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                   View Layout
                </a>
            </div>
        @endforeach
    </div>
</section>
@endsection
