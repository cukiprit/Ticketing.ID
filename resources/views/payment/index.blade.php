@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="container">
    <h2>Payment for Booking #{{ $booking->id }}</h2>
    <p>Total: Rp {{ number_format($booking->total_price) }}</p>

    <button id="pay-button" class="btn btn-primary">Pay Now</button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script type="text/javascript">
  document.getElementById('pay-button').onclick = function(){
    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            window.location.href = "/booking/{{ $booking->id }}";
        },
        onPending: function(result){
            alert("Waiting for payment!");
        },
        onError: function(result){
            alert("Payment failed!");
        },
        onClose: function(){
            alert("You closed the popup without finishing the payment");
        }
    })
  };
</script>
@endsection
