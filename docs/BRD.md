# Business Requirements Document (BRD)
Project Name: BookLoop - Sistem Manajemen Peminjaman Buku  

## 1. Pendahuluan

### 1.1 Tujuan Dokumen
Dokumen Business Requirements Document (BRD) ini dibuat untuk mendefinisikan kebutuhan fungsional dan bisnis dari aplikasi BookLoop. Dokumen ini menjadi acuan bagi pengembang, penguji (QC), dan pemangku kepentingan untuk memahami ruang lingkup dan batasan sistem.

### 1.2 Latar Belakang
Manajemen persediaan dan peminjaman buku yang dilakukan secara manual rentan terhadap hilangnya data, kesulitan pencarian buku, dan tidak terkendalinya jumlah stok sisa. Oleh karena itu, aplikasi berbasis web diperlukan untuk mengelola data absensi stok, riwayat peminjam, serta memberikan pengumuman/notifikasi proses persetujuan peminjaman.

---


## 2. Pengguna (Actors / User Roles)

Sistem memiliki dua jenis peran pengguna (roles):
1. Admin: Pengelola sistem (pustakawan/staf) yang memiliki akses penuh ke manajemen buku, pengguna, dan memiliki wewenang untuk menyetujui (approve) atau menolak (reject) tiket peminjaman dan pengembalian dari *User*.
2. User: Anggota (member) yang menggunakan sistem untuk melihat katalog buku, mengajukan peminjaman buku, dan mengembalikan buku.

---

## 3. Kebutuhan Fungsional (Functional Requirements)

### 3.1 Modul Autentikasi
- FR01 - Login: Pengguna (Admin & User) dapat masuk ke sistem menggunakan *Email* dan *Password*.
- FR02 - Register: Anggota baru dapat mendaftar langsung lewat form Registrasi (terdaftar sebagai role *User* default).
- FR03 - Logout: Pengguna yang masuk dapat keluar dari sistem dengan aman.

### 3.2 Modul Dashboard
- FR04 - Admin Dashboard: Menampilkan informasi analitik (Total User, Total Buku, Buku Tersedia, Buku Dipinjam).
- FR05 - User Dashboard: Menampilkan katalog/daftar buku dan ringkasan peminjaman milik user (Active Borrowings).

### 3.3 Modul Manajemen Buku (Admin Only)
- FR06 - CRUD Buku: Admin dapat menambah, melihat detail, mengedit, dan menghapus buku. Data yang disimpan antara lain: *Cover Gambar, Judul, Penulis, Tahun Terbit, Jumlah Halaman, Sinopsis, dan Stok*.
- FR07 - Search Buku: Admin dapat melakukan pencarian buku berdasarkan judul/penulis.

### 3.4 Modul Manajemen Pengguna (Admin Only)
- FR08 - CRUD User: Admin dapat mengelola data pengguna yang mendaftar.

### 3.5 Modul Transaksi Peminjaman (Borrowings)
- FR09 - Request Peminjaman (User): User dapat mengajukan permintaan peminjaman. Setiap *request* yang berhasil diajukan akan mengunci/mengurangi stok buku (-1) secara langsung agar tidak direbut user lain. Status awal adalah *Pending*.
- FR10 - Persetujuan Peminjaman (Admin): Admin menerima dan dapat memilih untuk:
  - Approve: Peminjaman disetujui, User dapat mengambil buku. Stok tetap berkurang.
  - Reject: Peminjaman ditolak, stok buku dikembalikan (+1).

### 3.6 Modul Transaksi Pengembalian (Reversions)
- FR11 - Request Pengembalian (User): User yang meminjam buku (status *Approved*) dapat memicu fungsi *Return* dengan mengisi *Notes* (kondisi buku saat dikembalikan). 
- FR12 - Persetujuan Pengembalian (Admin): Admin memeriksa fisik buku yang dikembalikan user dan dapat:
  - Approve Return: Buku kembali dikonfirmasi, stok ditambahkan (+1).
  - Reject Return: Permintaan pengembalian ditolak jika tidak sesuai/bermasalah.

### 3.7 Modul Notifikasi
- FR13 - System Notifications: Sistem mengirimkan push/database notification ke:
- Admin: Setiap kali User *request peminjaman* atau *request pengembalian*.
- User: Setiap kali Admin merespons (*approve/reject*) tiket peminjaman dan pengembalian.

---

## 4. Kebutuhan Non-Fungsional (Non-Functional Requirements)

- Keamanan: Routing dikunci oleh *Middleware Authentication* dan *Role Protection* yang mencegah User masuk ke wilayah Admin dan sebaliknya.
- Integritas Data Relasional: Jika sebuah *Book* atau *User* dihapus, histori peminjaman akan ikut disinkronisasi (*Cascade On Delete*).
- Antarmuka (UI): Desain dibangun secara responsif menggunakan *Bootstrap* dan template *OneUI*.
