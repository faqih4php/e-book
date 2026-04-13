# Dokumentasi Fungsi Fitur Aplikasi (Feature Flow)
Dokumen ini merangkum setiap controller dan method yang bekerja mengatur logika pada aplikasi BookLoop.

---


## 1. Fitur Autentikasi (`AuthController.php`)

- Fungsi Login: Menerima request email & password. Sistem memisahkan arah redirect berdasarkan *Role* (Kondisi jika `role === admin`, diarahkan ke `/dashboard-admin`, selain itu ke `/dashboard-user`).
- Fungsi Register: Pendaftaran untuk role user. *Password hashing* otomatis dienkripsi dengan `bcrypt/Hash::make()`. Akun default otomatis bertindak sebagai `user`.
- Fungsi Logout: Mengakhiri sesi (*invalidate/regenerate Token*) dan kembali ke laman Login. Semua URL lain diamankan menggunakan middleware bawaan Auth dan limit Role `EnsureRole.php`.

---


## 2. Fitur Manajemen Book / Katalog by Admin (`BookController.php`)

- Menampilkan total buku dengan Pagination/All data.
- Pencarian / Search: Melakukan filter pencarian by title dan author menggunakan klausa `WHERE LIKE`.
- Manajemen Storage Image File: 
  - Saat men-*create*, file Image di *upload* dan disimpan di dalam `storage/app/public/books`.
  - Saat meng-*update*, fungsi mengecek `hasFile('image')`. Jika ada, *Storage* akan menghapus file lama secara otomatis dan *request store* yang terbaru demi efisiensi memori disk server.
  - Saat men-*destroy* (delete), *Storage file* gambar otomatis ikut dihapus, lalu row database di hapus.

---


## 3. Fitur Peminjaman Buku (Borrowing Path)

Alur Peminjaman dipisah menjadi 2 Controller (Sisi User & Sisi Admin).

### Sisi User (`UserBorrowingController.php`)
- User mengakses list katalog yang bisa di pinjam.
- Melakukan Pinjaman (Store): 
  Sistem mengecek jika `$book->stock <= 0` maka akan error. Jika valid, Stok Buku langsung dipotong di awal `$book->decrement('stock')` walaupun status awal pengajuan peminjaman masih bernilai `pending`. Mekanisme ini berguna seperti 'Booking Barang' agar tidak keburu direbut user lain saat masih di *review* admin.
- Kemudian record Database tersimpan, merigger *Trait Notifiable* mengirim alert peminjaman sukses ke seluruh user bersetatus `Admin`.

### Sisi Admin (`BorrowingController.php`)
- Admin melihat List antrian yang berstatus `pending`.
- Approve: Merubah status ke `approved`. Mengirim Notifikasi ke peminjam.
- Reject: Merubah status ke `rejected`. Karena sebelumnya stok pinjaman dipotong dari sisi user, maka di sini Admin *mengembalikan lagi stok bukunya ke katalog* `$borrowing->book->increment('stock')`. Mengirim Notifikasi penolakan ke peminjam.

---


## 4. Fitur Pengembalian Buku (Reversion Path)

Seperti proses peminjaman, alur pengembalian juga diproses secara estafet 2 belah pihak.

### Sisi User (`UserReversionController.php`)
- Menampilkan seluruh buku yang sedang digenggam oleh User tersebut. Kondisi list yang tampil:
  1. Record Borrowing berstatus `approved`
  2. Record tersebut *Belum memiliki reversion tiket sama sekali*, ATAU *Memiliki reversion namun di reject admin* maka akan dikembalikan lagi tombol *Return*-nya.
- Lapor Mengembalikan Buku (Store):
  User wajib menulis notes (misal "ada robek di cover depan"). Mengajukan Record Return yang statusnya `pending` lalu mentrigger notifikasi khusus Peringatan ke Admin bahwa User melaporkan sudah mengembalikan buku fisik.

### Sisi Admin (`ReversionController.php`)
- Admin melihat List laporan antrian pengembalian yang masih `pending`.
- Admin memeriksa apakah buku *fisik-nya* betul-betul dikembalikan.
- Approve Return: Mengubah status Reversion `approved`. Lalu yang paling penting: menambahkan kembali ketersediaan stok buku secara total ``$reversion->borrowing->book->increment('stock');``. Send notif ok ke user.
- Reject Return: Jika user klik *Return*, tapi fisik barang tidak ada. Maka admin berhak *menolak form*. Menolak form akan mengembalikan status ke Rejected (Stok tidak ditambah, user diminta laporan ulang). Send Notif Fail.

---


## 5. Fitur Database Notification (`NotificationController.php` & Namespace Notifications)

Fitur `bell_icon` sistem ini memakai skema bawaan database notifications laravel. 
- Merekam isi notif secara dinamis dalam bentuk format Payload array (berisi status text "Approved/Rejected", parameter warna button UI *danger/success*, beserta URL tujuannya).
- Fungsi `read()` bisa merekam jika notif di klik, status `unread` di database otomatis hilang dan User diarahkan ke form yang dimaksud. User juga bisa men-*destroy* / clear riwayat tersebut manual.
