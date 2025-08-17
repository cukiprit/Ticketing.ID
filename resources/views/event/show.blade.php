@extends('layouts.app')

@section('title', 'Book a Tenant')

@section('content')
<div class="px-4 md:px-16 space-y-6">
    <div class="bg-gray-800 text-white text-center py-2 rounded-lg">
        Stage
    </div>

    <div class="mt-6 flex gap-6 flex-wrap">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-green-500 border shadow"></div>
            <span class="text-sm text-gray-700">Available</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-blue-500 border shadow"></div>
            <span class="text-sm text-gray-700">Selected</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-red-500 border shadow"></div>
            <span class="text-sm text-gray-700">Booked</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-gray-400 border shadow"></div>
            <span class="text-sm text-gray-700">Blocked</span>
        </div>
    </div>

    @php
        $grouped = $event->layoutLokasi->groupBy('section')->map(function($seats){
            return $seats->groupBy('row');
        });
    @endphp

    <div class="space-y-8 overflow-x-auto">
        @foreach($grouped as $section => $rows)
            <div>
                <h2 class="font-semibold mb-2">{{ $section }}</h2>
                <div class="space-y-3">
                    @foreach($rows as $row => $seats)
                        <div class="flex gap-3 items-center">
                            <span class="w-6 font-bold">{{ $row }}</span>
                            <div class="flex gap-3">
                                @foreach($seats as $seat)
                                    <button
                                        class="seat-btn w-12 h-12 text-sm flex items-center justify-center rounded-lg font-semibold shadow
                                            @if($seat->status === 'available') bg-green-500 hover:bg-green-600
                                            @elseif($seat->status === 'booked') bg-red-500 cursor-not-allowed
                                            @else bg-gray-400 cursor-not-allowed
                                            @endif"
                                        @if($seat->status !== 'available') disabled @endif
                                        data-id="{{ $seat->id }}"
                                        data-row="{{ $seat->row }}"
                                        data-number="{{ $seat->number }}"
                                        data-price="{{ $seat->harga }}"
                                    >
                                        {{ $seat->number }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Booking summary + tenant form -->
    <div class="mt-10 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold mb-4">Booking Summary</h3>

        <div class="my-3">
            <h1 class="text-xl font-bold">{{ $event->acara }}</h1>
            <p><strong>Tanggal:</strong> {{ $event->tanggal_acara->format('d M Y') }}</p>
        </div>

        <div id="selected-seats" class="mb-4 text-sm text-gray-700">
            <p>No seats selected</p>
        </div>

        <p class="font-semibold">Total: <span id="total" class="text-blue-600">IDR 0</span></p>

        <form id="booking-form" action="{{ route('booking.store') }}" method="POST" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="seat_id" id="seat-id">

            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Nama</label>
                    <input type="text" name="nama" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">No Telp</label>
                    <input type="text" name="no_telp" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">NIK</label>
                    <input type="text" name="NIK" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700">
                    Confirm Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const seats = document.querySelectorAll('.seat-btn');
    const selectedSeatsDiv = document.getElementById('selected-seats');
    const totalEl = document.getElementById('total');
    const seatIdsInput = document.getElementById('seat-id');

    let selected = null; // only 1 seat
    let total = 0;

    seats.forEach(seat => {
        seat.addEventListener('click', () => {
            const id = seat.dataset.id;
            const price = parseFloat(seat.dataset.price);

            // unselect if same seat clicked
            if (selected && selected.id === id) {
                seat.classList.remove('bg-blue-500');
                seat.classList.add('bg-green-500');
                selected = null;
                total = 0;
            } else {
                // clear previous selection
                if (selected) {
                    const prevBtn = document.querySelector(`.seat-btn[data-id="${selected.id}"]`);
                    if (prevBtn) {
                        prevBtn.classList.remove('bg-blue-500');
                        prevBtn.classList.add('bg-green-500');
                    }
                }

                // select new one
                selected = {
                    id,
                    row: seat.dataset.row,
                    number: seat.dataset.number,
                    price
                };
                total = price;
                seat.classList.remove('bg-green-500');
                seat.classList.add('bg-blue-500');
            }

            renderSummary();
        });
    });

    function renderSummary() {
        if (!selected) {
            selectedSeatsDiv.innerHTML = '<p>No seat selected</p>';
            totalEl.textContent = `IDR 0`;
            seatIdsInput.value = '';
        } else {
            selectedSeatsDiv.innerHTML = `
                <div class="flex justify-between border-b py-1">
                    <span>${selected.row}-${selected.number}</span>
                    <span>IDR ${selected.price.toLocaleString('id-ID')}</span>
                </div>
            `;
            totalEl.textContent = `IDR ${total.toLocaleString('id-ID')}`;
            seatIdsInput.value = selected.id;
        }
    }
});
</script>
@endsection
