<x-mail::message>
# Konfirmasi Pemesanan

Halo, **{{ $booking->tenant->nama }}**,
Terima kasih telah melakukan pemesanan! Berikut detail pemesanan Anda:

- **Kode Booking:** {{ $booking->token }}
- **Nama Tenant:** {{ $booking->tenant->nama }}
- **Lokasi Tenant:** {{ $booking->layoutTempat->section }} {{ $booking->layoutTempat->row }}-{{ $booking->layoutTempat->number }}
- **Total Pembayaran:** Rp {{ number_format($booking->total) }}

<x-mail::button :url="route('booking.show', $booking->token)">
Lihat Detail Pemesanan
</x-mail::button>

Silahkan selesaikan pembayaran sebelum **{{ $booking->tenggat_pembayaran->format('d M Y H:i') }}**.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
