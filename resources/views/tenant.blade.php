@extends('layouts.app')

@section('title', 'Book a Tenant')

@section('content')
<section class="container mx-auto py-20 px-6">
    <h2 class="text-3xl font-bold mb-6">Choose Your Tenant Spot</h2>
    <p class="text-gray-600 mb-8">Click on an available spot to reserve it.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($layouts as $layout)
            <div class="p-6 border rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold">{{ $layout->event->acara }}</h3>
                <p class="text-gray-600 text-sm mb-2">{{ $layout->event->lokasi }}</p>
                <p class="text-gray-500 text-sm mb-4">📅 {{ $layout->event->tanggal_acara->format('d M Y') }}</p>
                <a href="#"
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                   View Layout
                </a>
            </div>
        @endforeach
    </div>

    <div class="w-full flex justify-center mb-6">
        <div class="bg-gray-800 text-white text-center font-bold py-4 px-12 rounded-lg shadow-lg">
            🎤 Stage
        </div>
    </div>

    <!-- Concert Layout -->
    <div id="layout" class="grid grid-cols-5 gap-4 justify-center">
        @for ($i = 1; $i <= 25; $i++)
            <div
                data-seat="{{ $i }}"
                class="seat w-12 h-12 flex items-center justify-center
                       border rounded cursor-pointer bg-gray-200 hover:bg-indigo-200">
                {{ $i }}
            </div>
        @endfor
    </div>

    <div class="mt-8">
        <h3 class="font-bold mb-2">Selected Seats:</h3>
        <div id="selected-seats" class="text-indigo-600 font-semibold"></div>
    </div>

    <form action="#" method="POST" class="mt-8">
        @csrf
        <input type="hidden" name="seats" id="seats-input">
        <button type="submit"
            class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
            Confirm Booking
        </button>
    </form>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const seats = document.querySelectorAll(".seat");
    const selectedSeats = [];
    const selectedSeatsDiv = document.getElementById("selected-seats");
    const seatsInput = document.getElementById("seats-input");

    seats.forEach(seat => {
        seat.addEventListener("click", () => {
            const seatNumber = seat.dataset.seat;

            if (seat.classList.contains("bg-green-400")) {
                // Deselect
                seat.classList.remove("bg-green-400");
                seat.classList.add("bg-gray-200");
                const index = selectedSeats.indexOf(seatNumber);
                if (index > -1) selectedSeats.splice(index, 1);
            } else {
                // Select
                seat.classList.remove("bg-gray-200");
                seat.classList.add("bg-green-400");
                selectedSeats.push(seatNumber);
            }

            selectedSeatsDiv.textContent = selectedSeats.join(", ");
            seatsInput.value = selectedSeats.join(",");
        });
    });
});
</script>
@endsection
