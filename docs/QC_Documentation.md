# Quality Control (QC) & Testing Documentation
**Project Name:** BookLoop - Sistem Manajemen Peminjaman Buku  

Dokumen ini memuat Test Plan dan Test Case Scenario untuk memvalidasi fitur-fitur yang dikembangkan di aplikasi peminjaman buku BookLoop.

---

## 1. Modul Autentikasi & Keamanan Akses (Access Control)


| Test Case ID | Skenario Tes | Langkah-Langkah | Hasil yang Diharapkan | Status QC |
|---|---|---|---|---|
| `AUTH-01` | Pendaftaran Akun Baru | Buka `/register`, isi data valid, klik Register. | Akun dibuat otomatis dengan role `user` dan langsung dialihkan ke User Dashboard. | ✅ Pass |
| `AUTH-02` | Autentikasi Valid | Login dengan email/password admin yg benar di `/login`. | Berhasil login, dialihkan ke `/dashboard-admin`. | ✅ Pass |
| `AUTH-03` | Autentikasi Invalid | Login dengan kredensial salah. | Muncul error "credentials do not match". | ✅ Pass |
| `AUTH-04` | Cek Role/Middleware User | Login sbg `user`, coba akses paksa URL `/dashboard-admin`. | Tampil error 403 Access Denied. | ✅ Pass |
| `AUTH-05` | Cek Role/Middleware Admin | Login sbg `admin`, coba akses URL `/user/borrowings`. | Tampil error 403 Access Denied. | ✅ Pass |

---

## 2. Modul Manajemen Buku (Admin)

| Test Case ID | Skenario Tes | Langkah-Langkah | Hasil yang Diharapkan | Status QC |


| `BOOK-01` | Tambah Buku Baru | Isi data lengkap, upload gambar cover, simpan. | Buku tersimpan di DB, gambar di-store di disk `public/books`, dan *redirect* sukses. | ✅ Pass |
| `BOOK-02` | Validasi Tambah Buku | Kosongkan field Stok/Tahun, lalu Submit. | Muncul error flash/Laravel Validation gagal diproses. | ✅ Pass |
| `BOOK-03` | Hapus Buku | Klik delete pada buku. | Record dihapus, *File Image lama dihapus dari Storage (public/books)*. | ✅ Pass |
| `BOOK-04` | Edit Buku & Ganti Image | Update data buku, upload image baru. | Update sukses, *image lama terganti image baru dan file lama di Storage terhapus otomatis*. | ✅ Pass |

---

## 3. Modul Manajemen Stok & Peminjaman (Flow Utama)

*Ini adalah inti logika dari aplikasi. Stok buku sangat penting dijaga validitasnya.*

| Test Case ID | Skenario Tes | Langkah-Langkah | Hasil yang Diharapkan (Constraint Stok) | Status QC |

| `BOR-01` | Stok Out of Bounds | User request minjam saat Stok Buku = 0. | Tampil alert "Book is out of stock", proses terhenti, status DB nihil. | ✅ Pass |
| `BOR-02` | User Request Borrow | User klik pinjam *Book A* (Stok awal = 5). | Request tercatat `pending`. **Stok seketika berkurang sisa 4.** Dikirim Notif ke Admin. | ✅ Pass |
| `BOR-03` | Admin Tolak Pinjaman | Admin klik *Reject* pd tiket *BOR-02*. | Status jadi `rejected`. **Stok seketika dikembalikan jadi 5.** Notif dikirim ke User. | ✅ Pass |
| `BOR-04` | Admin Setujui Pinjaman| Admin klik *Approve* pd tiket baru (Stok = 4). | Status jadi `approved`. **Stok tetap 4.** User bisa buat tiket *Return*. | ✅ Pass |
| `BOR-05` | Validasi Tanggal Pinjam| Saat User pinjam, Return Date < Borrow Date. | Sistem memblokir proses (Rule rule: `after:borrow_date`). | ✅ Pass |

---

## 4. Modul Pengembalian Buku (Reversions)

| Test Case ID | Skenario Tes | Langkah-Langkah | Hasil yang Diharapkan | Status QC |
|---|---|---|---|---|
| `REV-01` | Cek Tombol Return | Buka "My Borrowings" oleh User. | Hanya buku ber-status `approved` & belum pernah return yg muncul tombol kembalikan. | ✅ Pass |
| `REV-02` | Submit Return | User mengisi form note dan submit Return. | Tiket Reversion `pending` terbuat, notif masuk ke Admin. | ✅ Pass |
| `REV-03` | Admin Tolak Return | Admin *Reject Return* dari test `REV-02`. | Status reversion jadi `rejected`. Stok **TIDAK bertambah**. | ✅ Pass |
| `REV-04` | Admin Terima Return | Admin *Approve Return*. | Status reversion `approved`. **Stok buku bertambah (+1)**. | ✅ Pass |

---

## 5. Modul Notifikasi

| Test Case ID | Skenario Tes | Langkah-Langkah | Hasil yang Diharapkan | Status QC |
|---|---|---|---|---|
| `NOTIF-01` | Pembuatan Database Notif | Cek Lonceng di Header | Notif menampilkan ikon sukses/gagal secara dinamis, mengarahkan ke link. | ✅ Pass |
| `NOTIF-02` | Hapus & Clear Notif | Klik *hapus* atau hapus semua. | Notifikasi terhapus dari tampilan dan database. | ✅ Pass |
