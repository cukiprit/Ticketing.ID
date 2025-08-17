<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function pay($token)
    {
        $booking = Booking::where('token', $token)->firstOrFail();

        if ($booking->status === 'paid') {
            return redirect()->route('booking.show', $token)->with('message', 'Already Paid');
        }

        // generate midtrans transaction
        $params = [
            'transaction_details' => [
                'order_id'      => 'BOOK-' . $booking->id . '-' . time(),
                'gross_amount'  => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->tenant->nama,
                'email'      => $booking->tenant->email,
            ],
            'item_details' => [
                [
                    'id'       => $booking->id,
                    'price'    => $booking->total,
                    'quantity' => 1,
                    'name'     => 'Tenant Booking',
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // return view('payment.index', compact('snapToken', 'booking'));
        return response()->json(['snapToken' => $snapToken]);
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.serverKey');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $bookingId = explode('-', $request->order_id)[1];
            $booking = Booking::find($bookingId);

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $booking->status = 'confirmed';
                $booking->token = null;
                $booking->save();
            } elseif ($request->transaction_status == 'expire') {
                $booking->status = 'expired';
                $booking->save();
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
