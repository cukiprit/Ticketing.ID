<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->decimal('total_pembayaran', 16, 2);
            $table->enum('status', ['pending', 'success', 'failed', 'expired', 'challenge'])->default('pending');
            $table->string('faktur_midtrans');
            $table->string('midtrans_token');
            $table->string('metode_pembayaran')->nullable();
            $table->dateTime('waktu_settlement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
