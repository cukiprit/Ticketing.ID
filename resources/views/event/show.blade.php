@extends('layouts.app')

@section('title', 'Book a Tenant')

@section('content')
<div class="px-16 space-y-4">
    <div class="bg-gray-800 text-white text-center py-2 rounded-lg">
        Stage
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div id="legend" class="flex justify-center gap-4 mb-6">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded-sm mr-2"></div>
                        <span>Available</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded-sm mr-2"></div>
                        <span>Booked</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-500 rounded-sm mr-2"></div>
                        <span>Selected</span>
                    </div>
                </div>
                <div id="seat-map" class="mx-auto"></div>
            </div>
        </div>

        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h3 class="text-xl font-bold mb-4">Booking Summary</h3>

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium">Selected Seats:</span>
                        <span id="selected-count" class="font-bold">0</span>
                    </div>
                    <div id="selected-seats" class="bg-gray-50 p-3 rounded max-h-40 overflow-y-auto">
                        <p class="text-gray-500 text-sm">No seats selected</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg">Total:</span>
                        <span id="total" class="font-bold text-blue-600 text-xl">IDR 0</span>
                    </div>
                </div>

                <button id="book-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Confirm Booking
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')

<script>
$(document).ready(function() {
    const seatData = @json($layoutLokasi);

    // 1. Organize seats by row
    const rows = {};
    seatData.forEach(seat => {
        if (!rows[seat.row]) rows[seat.row] = [];
        rows[seat.row].push(seat);
    });

    // 2. Build seat map strings
    const seatMapStrings = Object.values(rows).map(rowSeats =>
        rowSeats.map(seat => seat.status === 'available' ? 'a' : 'u').join('')
    );

    // 3. Initialize seatCharts
    const sc = $('#seat-map').seatCharts({
        map: seatMapStrings,
        naming: {
            top: true,
            getLabel: function (character, row, column) {
                return column;
            },
            getId: function (character, row, column) {
                const rowKey = Object.keys(rows)[row - 1];
                return `${rowKey}_${column}`;
            }
        },
        click: function () {
            let newStatus;
            if (this.status() === 'available') {
                newStatus = 'selected';
            } else if (this.status() === 'selected') {
                newStatus = 'available';
            } else {
                return this.style();
            }

            // Return the new status first
            const result = newStatus;

            // Then update the summary AFTER status changes
            setTimeout(updateBookingSummary, 0);

            return result;
        }
    });

    // 4. Update booking summary
    function updateBookingSummary() {
        const selectedSeats = sc.find('selected').seatIds; // IDs of selected seats
        const count = selectedSeats.length;

        $('#selected-count').text(count);
        $('#book-btn').prop('disabled', count === 0);

        let summaryHTML = '';
        let total = 0;

        if (count > 0) {
            selectedSeats.forEach(seatId => {
                const seat = sc.get(seatId);
                const [row, number] = seatId.split('_');
                const seatDataObj = seatData.find(s => s.row === row && s.number == number);

                summaryHTML += `
                    <div class="flex justify-between py-2 border-b">
                        <span>${seatDataObj.row}-${seatDataObj.number}</span>
                        <span>IDR ${parseInt(seatDataObj.price).toLocaleString('id-ID')}</span>
                    </div>
                `;

                total += parseInt(seatDataObj.price);
            });
        } else {
            summaryHTML = '<p class="text-gray-500 text-sm">No seats selected</p>';
        }

        $('#selected-seats').html(summaryHTML);
        $('#total').text(`IDR ${total.toLocaleString('id-ID')}`);
    }

    // 5. Handle booking button
    $('#book-btn').click(function() {
        const selectedSeats = sc.find('selected').seatIds;
        if (selectedSeats.length === 0) {
            alert('Please select at least one seat');
            return;
        }

        const bookingData = selectedSeats.map(seatId => {
            const [row, number] = seatId.split('_');
            return seatData.find(s => s.row === row && s.number == number);
        });

        console.log('Booking data:', bookingData);
        alert(`Booking ${selectedSeats.length} seats. Total: ${$('#total').text()}`);
    });

    // Initialize
    updateBookingSummary();
});
</script>

@endpush
