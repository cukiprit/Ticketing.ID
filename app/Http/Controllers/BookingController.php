<?php

namespace App\Http\Controllers;

use App\Mail\BookingCreatedMail;
use App\Models\LayoutLokasi;
use App\Models\Tenant;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'seat_id' => 'required|exists:layout_lokasi,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'no_telp' => 'required|string|max:20',
            'NIK' => 'required|string|max:16',
        ]);

        DB::beginTransaction();
        try {
            $tenant = Tenant::firstOrCreate(
                [
                    'email' => $request->email,
                    'no_telp' => $request->no_telp
                ],
                [
                    'nama' => $request->nama,
                    'NIK' => $request->NIK
                ]
            );

            $seat = LayoutLokasi::where('id', $request->seat_id)->where('status', 'available')->first();

            if (!$seat) {
                return back()->with('error', 'Some seats are already booked or unavailable.');
            }

            $tenggat = Carbon::now()->addHours(2);
            $token = Str::uuid();

            $booking = Booking::create([
                'tenant_id' => $tenant->id,
                'event_id' => $request->event_id,
                'layout_tempat_id' => $seat->id,
                'total' => $seat->harga,
                'status' => 'pending',
                'tenggat_pembayaran' => $tenggat,
                'token' => $token,
            ]);

            $seat->update(['status' => 'booked']);

            DB::commit();

            Mail::to($tenant->email)->send(new BookingCreatedMail($booking));

            return redirect()->route('booking.show', $booking->token)
                ->with('success', 'Booking successful! Please proceed with payment.');
        } catch(\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }

    public function show($token)
    {
        $booking = Booking::where('token', $token)->with('tenant')->firstOrFail();

        return view('booking.show', compact('booking'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'token' => 'required|exists:bookings,token'
        ]);

        $booking = Booking::where('token', $request->token)->firstOrFail();

        $booking->status = 'confirmed';
        $booking->token = null;

        $booking->save();

        return redirect()->route('event.show', $booking->event_id)
            ->with('success', 'Payment successful! Booking confirmed.');
        }
}
