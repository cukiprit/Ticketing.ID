@extends('layouts.app')

@section('content')
<div class="px-16 my-16 min-h-screen">
    <h2 class="text-2xl font-bold mb-6">Booking Detail</h2>

    <div class="bg-white rounded-lg shadow-md overflow-hidden-md mb-6">
        <div class="p-6">
            <h5 class="text-xl font-semibold mb-4">{{ $booking->tenant->name }}</h5>
            <p><strong>Booking Code:</strong> {{ $booking->token }}</p>
            <p><strong>Date:</strong> {{ $booking->event->tanggal_acara->format('d M Y') }}</p>
            <p><strong>Seats:</strong> {{ $booking->layoutTempat->section }} {{ $booking->layoutTempat->row }}-{{ $booking->layoutTempat->number }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($booking->total, 0, ',', '.') }}</p>
        </div>
    </div>

    <button id="pay-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Proceed to Payment
    </button>
</div>
@endsection


@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script type="text/javascript">
  $('#pay-button').on('click', function(){
      $.ajax({
            url: "{{ route('payment.pay', $booking->token) }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            method: "POST",
            success: function (response) {
                snap.pay(response.snapToken, {
                    onSuccess: function(result){
    console.log('Success:', result);
    // Hit confirm endpoint via form POST
    const form = $('<form>', {
        method: 'POST',
        action: "{{ route('booking.confirm') }}"
    }).append($('<input>', {
        type: 'hidden',
        name: '_token',
        value: '{{ csrf_token() }}'
    })).append($('<input>', {
        type: 'hidden',
        name: 'token',
        value: '{{ $booking->token }}'
    }));

    $('body').append(form);
    form.submit();
},
                    onPending: function(result){
                        console.log('Pending:', result);
                        alert('Waiting for payment!');
                    },
                    onError: function(result){
                        console.log('Error:', result);
                        alert('Payment failed!');
                    },
                    onClose: function(){
                        alert('You closed the popup without finishing the payment');
                    }
                });
            },
            error: function (xhr) {
                alert('Failed to get SnapToken');
                console.error(xhr.responseText);
            }
      });
  });
</script>
@endpush

