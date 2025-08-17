# Ticketing Booking System

Sistem ini merupakan aplikasi **Event Organizer** berbasis **Laravel 10** yang memungkinkan tenant untuk melakukan pemesanan tempat (booking) dan pembayaran online menggunakan **Midtrans Snap API**.

---

## Fitur Utama

### 1. Tenant & Booking
- Tenant dapat mendaftar dan melakukan booking tempat pada event.
- Pilihan kursi/tenant berdasarkan layout yang tersedia.
- Sistem memvalidasi kursi agar tidak double-booking.

### 2. Pembayaran
- Pembayaran dilakukan melalui Midtrans Snap.
- Token Midtrans di-generate saat proses booking.
- Status booking otomatis diperbarui setelah pembayaran sukses (`confirmed`).
- Token booking dihapus setelah pembayaran berhasil sehingga user tidak bisa membayar ulang.

### 3. Admin
- Melihat daftar booking, status pembayaran, dan data tenant.
- Mengelola layout lokasi, event, dan kapasitas tenant.

---

## Instalasi

1. Clone repository:

```bash
git clone https://github.com/username/event-organizer.git
cd event-organizer
```

---

---

Admin page

```
/admin/login
```

```
admin@gmail.com
password
```

---

## Perhatian

Pastikan pada file .env terdapat variabel berikut:

```
APP_NAME="Event Organizer"
APP_URL=http://localhost:8000

### Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_organizer
DB_USERNAME=root
DB_PASSWORD=

### Midtrans
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false

### SMTP
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="admin@ticketing.com"
MAIL_FROM_NAME="${APP_NAME}"
```
