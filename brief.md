# Brief Frontend Website Part Time

## 1. Ringkasan Project

Project ini bernama partimeku. partimeku adalah website platform part time (umkm) yang mempertemukan mahasiswa pencari kerja part time dengan penyedia lowongan part time. Project dibuat menggunakan Laravel 13 dan Tailwind CSS v4.

Project ini berfokus pada frontend, tetapi tetap harus memiliki route dan controller Laravel agar aplikasi bisa dijalankan dan digunakan dengan dummy data. Tidak perlu membuat backend penuh, autentikasi asli, database, migration, API, atau penyimpanan data permanen.

Semua data yang tampil di halaman menggunakan dummy data. Dummy data nantinya akan disediakan melalui file `dummy-data.json`.

Role utama aplikasi:

```txt
1. Admin
2. Mahasiswa / Pelamar
3. Penyedia Part Time
```

Selain halaman dashboard berdasarkan role, aplikasi juga memiliki halaman public yang bisa diakses tanpa login.

---

## 2. Tujuan Project

Tujuan project ini adalah membuat frontend aplikasi part time yang terlihat siap digunakan, lengkap secara flow, konsisten secara desain, dan dapat dinavigasi seperti aplikasi sungguhan walaupun semua data masih dummy.

Hasil akhir yang diharapkan:

```txt
1. Aplikasi Laravel bisa dijalankan secara lokal.
2. Semua route halaman tersedia.
3. Semua controller untuk halaman tersedia.
4. Semua halaman menggunakan dummy data.
5. Semua halaman public, admin, mahasiswa, dan penyedia selesai dibuat.
6. UI konsisten sesuai brief.
7. Mahasiswa menggunakan pendekatan mobile first.
8. Admin dan penyedia tetap responsive.
9. Toast custom tersedia.
10. Modal konfirmasi custom tersedia.
11. Chart dummy menggunakan Chart.js.
12. Komponen reusable tersedia.
```

---

## 3. Scope Project

### 3.1 Yang Harus Dikerjakan

```txt
1. Membuat frontend Laravel Blade.
2. Membuat route untuk semua halaman.
3. Membuat controller untuk semua halaman.
4. Membaca atau menggunakan dummy data untuk kebutuhan tampilan.
5. Membuat layout public.
6. Membuat layout admin.
7. Membuat layout mahasiswa.
8. Membuat layout penyedia.
9. Membuat halaman public.
10. Membuat halaman admin.
11. Membuat halaman mahasiswa.
12. Membuat halaman penyedia.
13. Membuat komponen UI reusable.
14. Membuat toast custom.
15. Membuat confirm modal custom.
16. Membuat chart menggunakan Chart.js.
17. Membuat responsive design.
18. Membuat tampilan mobile first untuk mahasiswa.
19. Membuat state tampilan menggunakan dummy data.
20. Membuat navigasi antar halaman berjalan.
```

### 3.2 Yang Tidak Perlu Dikerjakan

```txt
1. Tidak perlu membuat database MySQL.
2. Tidak perlu membuat migration.
3. Tidak perlu membuat model Eloquent untuk database asli.
4. Tidak perlu membuat API.
5. Tidak perlu membuat autentikasi asli.
6. Tidak perlu membuat session login asli.
7. Tidak perlu menyimpan data permanen.
8. Tidak perlu proses upload file asli.
9. Tidak perlu email reset password asli.
10. Tidak perlu validasi backend kompleks.
```

### 3.3 Catatan Penting

Walaupun project hanya frontend, aplikasi tetap harus terasa bisa digunakan. Maka semua tombol, form, modal, toast, chart, table, filter dummy, dan navigasi harus dibuat seperti aplikasi nyata.

Contoh:

```txt
1. Tombol delete membuka confirm modal.
2. Tombol submit form menampilkan toast sukses.
3. Tombol approve/reject membuka modal atau menampilkan toast.
4. Link detail membuka halaman detail dengan dummy data.
5. Table memiliki search/filter secara tampilan.
6. Chart menampilkan dummy statistik.
```

---

## 4. Tech Stack

```txt
Framework    : Laravel 13
Template     : Blade
Styling      : Tailwind CSS v4
Font         : Inter
Icon         : FontAwesome
Chart        : Chart.js
Data         : dummy-data.json / static dummy data
```

Tailwind CSS harus di-install, bukan hanya menggunakan CDN.

CDN hanya boleh digunakan untuk:

```txt
1. Font
2. Icon
3. Chart
```

---

## 5. Color Palette

Gunakan color palette berikut:

```txt
Primary     : #1E3A8A
Secondary   : #FBBF24
Accent      : #FBBF24
Background  : #FFFFFF
Text Dark   : #111827
Text Gray   : #6B7280
Border      : #E5E7EB
Surface     : #F9FAFB
Danger      : #DC2626
Success     : #16A34A
Warning     : #F59E0B
Info        : #2563EB
```

Catatan penting:

```txt
Kode primary yang benar adalah #1E3A8A.
Jangan gunakan #IE3A8A karena huruf pertama harus angka 1, bukan huruf I.
```

---

## 6. UI Rules

Semua halaman wajib mengikuti aturan UI berikut:

```txt
1. Gunakan desain clean, rapi, modern, dan profesional. refrensi ui untuk dashboard adalah vercel dan untuk mobile adalah app glints.
2. Background utama putih.
3. Jangan menggunakan gradient.
4. Jangan menggunakan bubble UI.
5. Jangan menggunakan emoji di UI.
6. Jangan menggunakan rounded berlebihan.
7. Gunakan rounded-md saja.
8. Gunakan font Inter.
9. Gunakan FontAwesome untuk icon.
10. Gunakan spacing konsisten.
11. Gunakan border tipis pada card, table, input, dan modal.
12. Gunakan shadow secukupnya, jangan berlebihan.
13. Jangan menggunakan warna di luar palette kecuali untuk status standar.
14. Semua komponen reusable harus dibuat sebagai component Blade.
15. Toast harus custom dan reusable.
16. Confirm delete harus menggunakan modal custom.
17. Jangan gunakan alert(), confirm(), atau prompt() bawaan JavaScript.
18. Jangan menampilkan emoji pada button, empty state, alert, toast, atau card.
19. Minimalkan komentar pada kode program
```

---

## 7. Responsive Rules

### 7.1 Public Pages

```txt
1. Public pages harus bagus di desktop dan mobile.
2. Navbar desktop menggunakan horizontal menu.
3. Navbar mobile menggunakan hamburger menu.
4. Card lowongan stack di mobile.
5. Landing page tidak boleh terlalu ramai.
```

### 7.2 Admin

```txt
1. Admin diprioritaskan untuk desktop.
2. Tetap harus responsive di tablet dan mobile.
3. Sidebar desktop fixed atau sticky.
4. Sidebar mobile boleh menjadi drawer.
5. Table boleh menggunakan horizontal scroll di mobile.
6. Dashboard card stack di mobile.
```

### 7.3 Penyedia

```txt
1. Penyedia diprioritaskan untuk desktop dan tablet.
2. Tetap nyaman digunakan di mobile.
3. Sidebar desktop, drawer di mobile.
4. Table boleh scroll horizontal di mobile.
5. Form harus tetap mudah diisi di mobile.
```

### 7.4 Mahasiswa

Mahasiswa wajib menggunakan pendekatan mobile first tapi di desktop tetep responsive.

```txt
1. Tampilan mobile mahasiswa harus menjadi prioritas utama.
2. Desktop mahasiswa tetap harus terlihat bagus.
3. Gunakan card layout untuk daftar lowongan di mobile.
4. Gunakan card layout untuk lamaran di mobile.
5. Hindari table besar pada mobile mahasiswa.
6. Filter lowongan di mobile menggunakan drawer/modal.
7. Button utama harus mudah dijangkau.
8. Bottom navigation boleh digunakan untuk mahasiswa di mobile.
9. Desktop mahasiswa boleh menggunakan sidebar atau top navigation.
```

---

## 8. Komponen Reusable

Buat reusable component untuk kebutuhan berikut:

```txt
1. Button
2. Input
3. Textarea
4. Select
5. Checkbox
6. Radio
7. Card
8. Badge
9. Status Badge
10. Modal
11. Confirm Modal
12. Toast
13. Table
14. Pagination
15. Search Input
16. Filter Dropdown
17. File Upload
18. Sidebar
19. Navbar
20. Breadcrumb
21. Empty State
22. Loading State
23. Tabs
24. Dashboard Summary Card
25. Chart Card
26. Review Card
27. Job Card
28. Application Card
29. Application Status Timeline
30. Rating Stars
```

Komponen harus konsisten mengikuti palette dan UI rules.

---

## 9. Status yang Digunakan

### 9.1 Status Verifikasi Akun

```txt
Belum Upload Dokumen
Menunggu Verifikasi
Terverifikasi
Ditolak
```

### 9.2 Status Lowongan

```txt
Draft
Menunggu Review
Aktif
Ditolak
Ditutup
Selesai
```

### 9.3 Status Lamaran

Gunakan status berikut untuk frontend:

```txt
Menunggu
Diproses
Diterima
Ditolak
Selesai
```

Jika ingin menampilkan flow lebih lengkap di timeline, boleh gunakan:

```txt
Menunggu Review
Dilihat
Diproses
Diterima
Sedang Bekerja
Selesai
Ditolak
Dibatalkan
```

### 9.4 Status Review

```txt
Belum Bisa Review
Menunggu Review
Sudah Direview
```

---

## 10. Flow Utama Aplikasi

### 10.1 Flow Public ke Mahasiswa

```txt
Pengunjung membuka landing page
→ melihat lowongan terbaru
→ membuka daftar lowongan
→ membuka detail lowongan
→ klik Lamar Sekarang
→ diarahkan ke login/register mahasiswa
→ mahasiswa login
→ mahasiswa melamar lowongan
```

### 10.2 Flow Public ke Penyedia

```txt
Pengunjung membuka landing page
→ klik Pasang Lowongan
→ memilih daftar sebagai penyedia
→ mengisi data usaha/instansi
→ upload dokumen verifikasi
→ menunggu verifikasi admin
→ setelah terverifikasi, penyedia bisa membuat lowongan
```

### 10.3 Flow Mahasiswa

```txt
Mahasiswa registrasi
→ upload KTM
→ status akun Menunggu Verifikasi
→ login
→ masuk dashboard terbatas jika belum diverifikasi
→ setelah diverifikasi, mahasiswa bisa melamar
→ mahasiswa mencari lowongan
→ melihat detail lowongan
→ menyimpan favorit atau mengajukan lamaran
→ upload atau memilih CV
→ memantau status lamaran
→ jika diterima, mahasiswa bekerja
→ setelah pekerjaan selesai, mahasiswa memberi review ke penyedia
→ mahasiswa menerima review dari penyedia
```

### 10.4 Flow Penyedia Lowongan

```txt
Penyedia registrasi
→ upload data usaha/instansi
→ status akun Menunggu Verifikasi
→ login
→ masuk dashboard terbatas jika belum diverifikasi
→ setelah diverifikasi, penyedia bisa membuat lowongan
→ lowongan berstatus Menunggu Review
→ admin menyetujui lowongan
→ lowongan menjadi Aktif dan tampil ke mahasiswa
→ mahasiswa melamar
→ penyedia melihat lamaran masuk
→ penyedia memproses lamaran
→ penyedia menerima atau menolak lamaran
→ setelah pekerjaan selesai, penyedia menandai lamaran Selesai
→ penyedia memberi review ke mahasiswa
→ penyedia menerima review dari mahasiswa
```

### 10.5 Flow Admin

```txt
Admin login
→ melihat dashboard
→ memverifikasi akun mahasiswa dan penyedia
→ memverifikasi lowongan dari penyedia
→ mengelola pengguna
→ mengelola kategori
→ mengelola lowongan
→ mengelola lamaran
→ melihat laporan
→ mengelola profil admin
```

### 10.6 Flow Review Dua Arah

```txt
Lamaran diterima
→ mahasiswa bekerja
→ penyedia menandai pekerjaan selesai
→ status lamaran menjadi Selesai
→ mahasiswa bisa memberi review ke penyedia
→ penyedia bisa memberi review ke mahasiswa
```

Aturan review:

```txt
1. Review hanya bisa diberikan setelah status lamaran Selesai.
2. Mahasiswa hanya bisa memberi 1 review ke penyedia untuk 1 lamaran.
3. Penyedia hanya bisa memberi 1 review ke mahasiswa untuk 1 lamaran.
4. Review berisi rating 1 sampai 5 dan komentar.
5. Review tampil di halaman review masing-masing role.
6. Untuk frontend, aksi review cukup menampilkan modal/form dan toast sukses.
```

---

## 11. Route dan Controller Rules

Karena hasil akhirnya harus berupa aplikasi Laravel yang bisa digunakan dengan dummy data, maka route dan controller tetap harus dibuat.

### 11.1 Route Rules

```txt
1. Semua halaman harus punya route.
2. Route boleh menggunakan controller method.
3. Route detail menggunakan parameter ID dummy.
4. Route boleh menampilkan data dummy berdasarkan ID.
5. Form tidak perlu menyimpan data asli.
6. Tombol submit boleh redirect atau menampilkan toast.
```

### 11.2 Controller Rules

```txt
1. Buat controller untuk public pages.
2. Buat controller untuk admin pages.
3. Buat controller untuk mahasiswa pages.
4. Buat controller untuk penyedia pages.
5. Controller mengambil dummy data dari helper/service/file static.
6. Controller mengirim data ke Blade view.
```

Rekomendasi controller:

```txt
PublicController
Admin\DashboardController
Admin\VerificationController
Admin\UserController
Admin\CategoryController
Admin\JobController
Admin\ApplicationController
Admin\ReportController
Admin\ProfileController
Mahasiswa\DashboardController
Mahasiswa\JobController
Mahasiswa\FavoriteController
Mahasiswa\ApplicationController
Mahasiswa\ReviewController
Mahasiswa\ProfileController
Penyedia\DashboardController
Penyedia\CompanyProfileController
Penyedia\JobController
Penyedia\ApplicationController
Penyedia\ReviewController
Penyedia\ProfileController
```

---

## 12. Dummy Data Rules

Dummy data akan disediakan melalui file `dummy-data.json`.

Frontend harus menggunakan dummy data untuk:

```txt
1. Statistik dashboard
2. User admin
3. Data mahasiswa
4. Data penyedia
5. Kategori pekerjaan
6. Lowongan pekerjaan
7. Lamaran
8. Review
9. Chart
10. Laporan
11. Status verifikasi
12. Status lowongan
13. Status lamaran
```

Jika file `dummy-data.json` belum tersedia, buat dummy data sementara di controller atau helper. Setelah `dummy-data.json` tersedia, gunakan data dari file tersebut.

---

## 13. Public Pages

Public pages adalah halaman yang dapat diakses tanpa login.

### 13.1 Daftar Public Pages

```txt
1. Landing Page
2. Daftar Lowongan Public
3. Detail Lowongan Public
4. Pilih Role Registrasi
5. Register Mahasiswa
6. Register Penyedia
7. Login
8. Forgot Password
9. Reset Password
```

### 13.2 Route Public

```txt
/
/lowongan
/lowongan/{id}
/register
/register/mahasiswa
/register/penyedia
/login
/forgot-password
/reset-password
```

### 13.3 Landing Page

Route:

```txt
/
```

Isi halaman:

```txt
1. Navbar
2. Hero section
3. Statistik singkat
4. Kategori pekerjaan
5. Lowongan terbaru
6. Cara kerja aplikasi
7. Keunggulan platform
8. CTA daftar mahasiswa
9. CTA daftar penyedia
10. Footer
```

Hero section:

```txt
Judul utama
Deskripsi singkat
Button Cari Lowongan
Button Pasang Lowongan
```

Statistik singkat:

```txt
Total lowongan aktif
Total penyedia terverifikasi
Total mahasiswa terdaftar
Total lamaran berhasil
```

CTA:

```txt
Cari Lowongan
Daftar sebagai Mahasiswa
Daftar sebagai Penyedia
```

### 13.4 Daftar Lowongan Public

Route:

```txt
/lowongan
```

Fitur:

```txt
Search lowongan
Filter kategori
Filter lokasi
Filter jadwal kerja
Filter gaji
Pagination
```

Data card lowongan:

```txt
Nama pekerjaan
Nama penyedia
Rating penyedia
Kategori
Lokasi
Gaji/upah
Jadwal kerja
Kuota
Batas akhir lamaran
Button Detail
```

Catatan:

```txt
Hanya tampilkan lowongan dengan status Aktif.
```

### 13.5 Detail Lowongan Public

Route:

```txt
/lowongan/{id}
```

Isi halaman:

```txt
Nama pekerjaan
Nama penyedia
Logo penyedia
Rating penyedia
Jumlah review penyedia
Kategori
Lokasi
Gaji/upah
Tipe gaji
Jadwal kerja
Kuota tersedia
Batas akhir lamaran
Deskripsi pekerjaan
Syarat pekerjaan
Review penyedia
Lowongan serupa
Button Lamar Sekarang
```

Jika user klik Lamar Sekarang dan belum login:

```txt
Arahkan ke halaman login.
```

### 13.6 Pilih Role Registrasi

Route:

```txt
/register
```

Isi halaman:

```txt
Card Daftar sebagai Mahasiswa
Card Daftar sebagai Penyedia Lowongan
```

Arah button:

```txt
Daftar Mahasiswa → /register/mahasiswa
Daftar Penyedia → /register/penyedia
```

### 13.7 Login

Route:

```txt
/login
```

Login digunakan untuk mahasiswa dan penyedia.

Input:

```txt
Email / username
Password
Button login
Link lupa password
Link daftar akun
```

Setelah login secara frontend/dummy:

```txt
Mahasiswa → /mahasiswa/dashboard
Penyedia → /penyedia/dashboard
```

Untuk admin:

```txt
Admin menggunakan route terpisah: /admin/login
```

---

## 14. Admin Pages

Admin memiliki 10 halaman utama.

### 14.1 Daftar Pages Admin

```txt
1. Login Admin
2. Dashboard Admin
3. Verifikasi Akun
4. Verifikasi Lowongan
5. Manajemen Pengguna
6. Manajemen Kategori
7. Manajemen Lowongan
8. Manajemen Lamaran
9. Laporan
10. Profil Admin
```

### 14.2 Route Admin

```txt
/admin/login
/admin/dashboard
/admin/verifikasi-akun
/admin/verifikasi-lowongan
/admin/users
/admin/categories
/admin/jobs
/admin/applications
/admin/reports
/admin/profile
```

### 14.3 Login Admin

Route:

```txt
/admin/login
```

Isi halaman:

```txt
Input email/username
Input password
Button login
Validasi error dummy
```

### 14.4 Dashboard Admin

Route:

```txt
/admin/dashboard
```

Summary card:

```txt
Total mahasiswa terdaftar
Total penyedia lowongan
Total lowongan aktif
Total lamaran masuk
```

Tambahan data ringkas:

```txt
Mahasiswa menunggu verifikasi
Penyedia menunggu verifikasi
Lowongan menunggu review
Lamaran diterima bulan ini
```

Chart menggunakan Chart.js:

```txt
Grafik jumlah lowongan per bulan
Grafik jumlah pelamar per bulan
```

Table:

```txt
5 data lamaran terbaru
5 akun menunggu verifikasi
5 lowongan menunggu review
```

### 14.5 Verifikasi Akun

Route:

```txt
/admin/verifikasi-akun
```

Fungsi:

```txt
Admin memverifikasi akun mahasiswa dan penyedia.
```

Isi halaman:

```txt
Tab Mahasiswa
Tab Penyedia
Table akun pending
Search
Filter status
Detail akun
Preview dokumen
Approve
Reject
Input alasan reject
```

Dokumen mahasiswa:

```txt
KTM
CV opsional
```

Dokumen penyedia:

```txt
Dokumen usaha / instansi
Logo usaha
Data penanggung jawab
```

### 14.6 Verifikasi Lowongan

Route:

```txt
/admin/verifikasi-lowongan
```

Fungsi:

```txt
Admin meninjau lowongan dari penyedia sebelum tampil ke mahasiswa.
```

Isi halaman:

```txt
Table lowongan menunggu review
Search
Filter kategori
Filter status
Detail lowongan
Approve
Reject
Input alasan reject
```

Data yang dicek:

```txt
Nama pekerjaan
Nama penyedia
Kategori
Lokasi
Gaji/upah
Jadwal kerja
Kuota
Deskripsi pekerjaan
Syarat pekerjaan
```

### 14.7 Manajemen Pengguna

Route:

```txt
/admin/users
```

Fungsi:

```txt
Admin mengelola semua user.
```

Isi halaman:

```txt
Table pengguna
Search
Filter role
Filter status akun
Filter status verifikasi
Detail pengguna
Edit pengguna
Nonaktifkan akun
Hapus akun
```

Role:

```txt
Admin
Mahasiswa
Penyedia
```

Catatan frontend:

```txt
Gunakan modal custom untuk konfirmasi hapus.
Jangan gunakan alert bawaan JavaScript.
```

### 14.8 Manajemen Kategori

Route:

```txt
/admin/categories
```

Fungsi:

```txt
Admin mengelola kategori pekerjaan.
```

Isi halaman:

```txt
Table kategori
Tambah kategori
Edit kategori
Hapus kategori
Aktif/nonaktif kategori
Search
```

Contoh kategori:

```txt
F&B
Retail
Event
Admin
Tutor
Design
Cleaning
Barista
Kasir
Kurir
Customer Service
Warehouse
```

### 14.9 Manajemen Lowongan

Route:

```txt
/admin/jobs
```

Fungsi:

```txt
Admin mengelola semua lowongan.
```

Isi halaman:

```txt
Table lowongan
Search
Filter kategori
Filter penyedia
Filter status
Detail lowongan
Tambah lowongan
Edit lowongan
Hapus lowongan
Ubah status lowongan
```

Data table:

```txt
Nama pekerjaan
Penyedia
Kategori
Lokasi
Gaji
Kuota
Jumlah pelamar
Status
Tanggal dibuat
Aksi
```

Aksi:

```txt
Lihat detail
Edit
Tutup lowongan
Tandai selesai
Hapus
```

### 14.10 Manajemen Lamaran

Route:

```txt
/admin/applications
```

Fungsi:

```txt
Admin melihat dan mengelola data lamaran mahasiswa.
```

Isi halaman:

```txt
Table lamaran
Search
Filter status
Filter lowongan
Filter penyedia
Filter tanggal
Detail lamaran
Update status jika diperlukan
Timeline status lamaran
Review mahasiswa ke penyedia
Review penyedia ke mahasiswa
```

Data table:

```txt
Nama mahasiswa
Nama lowongan
Penyedia
Tanggal melamar
Status
Status review
Aksi
```

### 14.11 Laporan

Route:

```txt
/admin/reports
```

Jenis laporan:

```txt
Laporan data mahasiswa
Laporan data penyedia
Laporan data lowongan
Laporan data lamaran
Laporan verifikasi akun
Laporan lowongan aktif
Laporan lowongan selesai
Laporan review
```

Fitur frontend:

```txt
Filter tanggal
Filter role
Filter status
Filter kategori
Export PDF dummy button
Export Excel dummy button
Print dummy button
```

### 14.12 Profil Admin

Route:

```txt
/admin/profile
```

Isi halaman:

```txt
Edit nama
Edit email
Edit username
Ubah password
Logout
```

---

## 15. Penyedia Lowongan Pages

### 15.1 Daftar Pages Penyedia

```txt
1. Registrasi Penyedia
2. Login Penyedia
3. Dashboard Penyedia
4. Profil Usaha
5. Daftar Lowongan
6. Tambah Lowongan
7. Detail Lowongan
8. Edit Lowongan
9. Lamaran Masuk
10. Detail Lamaran
11. Review
12. Profil Akun
```

### 15.2 Route Penyedia

```txt
/register/penyedia
/login
/penyedia/dashboard
/penyedia/profil-usaha
/penyedia/jobs
/penyedia/jobs/create
/penyedia/jobs/{id}
/penyedia/jobs/{id}/edit
/penyedia/applications
/penyedia/applications/{id}
/penyedia/reviews
/penyedia/profile
```

### 15.3 Registrasi Penyedia

Route:

```txt
/register/penyedia
```

Input:

```txt
Nama penanggung jawab
Email
Username
Password
Konfirmasi password
Nomor telepon
Nama usaha / instansi
Jenis usaha / instansi
Alamat usaha / instansi
Deskripsi usaha / instansi
Upload dokumen verifikasi
```

Setelah registrasi secara tampilan:

```txt
Status akun: Menunggu Verifikasi
```

### 15.4 Dashboard Penyedia

Route:

```txt
/penyedia/dashboard
```

Summary card:

```txt
Jumlah lowongan aktif
Jumlah lowongan menunggu review
Jumlah lamaran masuk
Jumlah pelamar diterima
Rating penyedia
```

Chart:

```txt
Grafik lamaran masuk per bulan
```

Table:

```txt
5 lamaran terbaru
5 lowongan terbaru
```

Shortcut:

```txt
Tambah lowongan
Lihat lamaran masuk
Kelola profil usaha
```

Jika akun belum diverifikasi:

```txt
Tampilkan banner bahwa akun sedang menunggu verifikasi.
Disable tombol tambah lowongan.
```

### 15.5 Profil Usaha

Route:

```txt
/penyedia/profil-usaha
```

Isi halaman:

```txt
Nama usaha / instansi
Jenis usaha
Logo usaha
Nomor telepon usaha
Email usaha
Alamat usaha
Deskripsi usaha
Dokumen verifikasi
Status verifikasi
Alasan ditolak jika ada
```

Fitur tampilan:

```txt
Edit profil usaha
Upload logo
Upload ulang dokumen verifikasi
Lihat status verifikasi
```

### 15.6 Daftar Lowongan

Route:

```txt
/penyedia/jobs
```

Isi halaman:

```txt
Table lowongan
Search
Filter status
Filter kategori
Button tambah lowongan
Aksi detail
Aksi edit
Aksi tutup
Aksi hapus
```

Kolom table:

```txt
Nama pekerjaan
Kategori
Lokasi
Gaji/upah
Kuota
Jumlah pelamar
Status lowongan
Tanggal dibuat
Aksi
```

### 15.7 Tambah Lowongan

Route:

```txt
/penyedia/jobs/create
```

Input form:

```txt
Nama pekerjaan
Kategori pekerjaan
Deskripsi pekerjaan
Syarat pekerjaan
Lokasi
Gaji/upah
Tipe gaji
Jadwal kerja
Tanggal mulai kerja
Tanggal akhir kerja
Kuota
Batas akhir lamaran
Kontak tambahan opsional
```

Tipe gaji:

```txt
Per jam
Per hari
Per minggu
Per bulan
Per proyek
```

Setelah submit secara tampilan:

```txt
Status lowongan: Menunggu Review
```

### 15.8 Detail Lowongan

Route:

```txt
/penyedia/jobs/{id}
```

Isi halaman:

```txt
Detail informasi lowongan
Status review admin
Alasan reject jika ditolak
Jumlah pelamar
Jumlah pelamar diterima
Jumlah pelamar ditolak
Daftar pelamar terbaru
```

Aksi:

```txt
Edit lowongan
Tutup lowongan
Tandai selesai
Lihat semua pelamar
```

### 15.9 Edit Lowongan

Route:

```txt
/penyedia/jobs/{id}/edit
```

Isi halaman:

```txt
Form edit lowongan
Preview status lowongan
Info jika perubahan perlu review ulang
```

### 15.10 Lamaran Masuk

Route:

```txt
/penyedia/applications
```

Isi halaman:

```txt
Table lamaran
Search nama mahasiswa
Filter lowongan
Filter status lamaran
Filter tanggal
Detail lamaran
Update status lamaran
```

Kolom table:

```txt
Nama mahasiswa
Nama lowongan
Tanggal melamar
CV
Status lamaran
Status review
Aksi
```

### 15.11 Detail Lamaran

Route:

```txt
/penyedia/applications/{id}
```

Isi halaman:

```txt
Data mahasiswa
Nama lowongan yang dilamar
Tanggal melamar
CV yang dikirim
Catatan mahasiswa jika ada
Status lamaran
Catatan penyedia
Timeline status lamaran
Review mahasiswa ke penyedia
Review penyedia ke mahasiswa
```

Aksi:

```txt
Ubah status menjadi Diproses
Terima lamaran
Tolak lamaran
Tandai selesai
Download CV
Beri review mahasiswa jika status selesai
```

Data mahasiswa yang tampil:

```txt
Nama lengkap
Email
Nomor telepon
Kampus
Jurusan
Semester
Alamat
CV
Rating mahasiswa
Jumlah review mahasiswa
```

Catatan:

```txt
KTM mahasiswa tidak perlu ditampilkan ke penyedia.
KTM cukup untuk verifikasi admin.
```

### 15.12 Review Penyedia

Route:

```txt
/penyedia/reviews
```

Isi halaman:

```txt
Rating rata-rata penyedia
Jumlah review diterima
Tab review diterima
Tab review diberikan
```

Review diterima dari mahasiswa:

```txt
Nama mahasiswa
Nama lowongan
Rating
Komentar
Tanggal review
```

Review diberikan ke mahasiswa:

```txt
Nama mahasiswa
Nama lowongan
Rating
Komentar penyedia
Tanggal review
```

### 15.13 Profil Akun Penyedia

Route:

```txt
/penyedia/profile
```

Isi halaman:

```txt
Edit nama penanggung jawab
Edit email
Edit username
Edit nomor telepon
Ubah password
Logout
```

---

## 16. Mahasiswa Pages

Mahasiswa harus menggunakan desain mobile first, tapi tetap bagus di desktop.

### 16.1 Daftar Pages Mahasiswa

```txt
1. Registrasi Mahasiswa
2. Login Mahasiswa
3. Dashboard Mahasiswa
4. Lowongan Pekerjaan
5. Detail Lowongan
6. Lowongan Favorit
7. Lamaran Saya
8. Detail Lamaran
9. Review
10. Profil Mahasiswa
```

### 16.2 Route Mahasiswa

```txt
/register/mahasiswa
/login
/mahasiswa/dashboard
/mahasiswa/jobs
/mahasiswa/jobs/{id}
/mahasiswa/favorites
/mahasiswa/applications
/mahasiswa/applications/{id}
/mahasiswa/reviews
/mahasiswa/profile
```

### 16.3 Registrasi Mahasiswa

Route:

```txt
/register/mahasiswa
```

Input:

```txt
Nama lengkap
Email
Username
Password
Konfirmasi password
Nomor telepon
Nama kampus
Jurusan
Semester
Alamat
Upload KTM
```

Setelah registrasi secara tampilan:

```txt
Status verifikasi: Menunggu Verifikasi
```

### 16.4 Dashboard Mahasiswa

Route:

```txt
/mahasiswa/dashboard
```

Card:

```txt
Lowongan tersedia
Total lamaran saya
Lamaran diproses
Lamaran diterima
Rating saya
```

Jika ingin 4 card saja:

```txt
Lowongan tersedia
Total lamaran
Lamaran diproses
Lamaran diterima
```

Section:

```txt
Lowongan terbaru
Status lamaran terakhir
Review terbaru yang diterima
```

Mobile first:

```txt
Gunakan card stack.
Jangan terlalu banyak table.
Gunakan bottom navigation atau tab menu yang nyaman di mobile.
```

### 16.5 Lowongan Pekerjaan

Route:

```txt
/mahasiswa/jobs
```

Fitur:

```txt
Search lowongan
Filter kategori
Filter lokasi
Filter jadwal
Filter gaji
Filter status
Simpan favorit
Pagination
```

Di mobile:

```txt
Gunakan card lowongan.
Filter dibuka lewat drawer/modal.
```

Data card lowongan:

```txt
Nama pekerjaan
Nama penyedia
Rating penyedia
Kategori
Lokasi
Gaji/upah
Jadwal kerja
Kuota
Status
Button detail
Button favorit
```

### 16.6 Detail Lowongan

Route:

```txt
/mahasiswa/jobs/{id}
```

Isi halaman:

```txt
Nama pekerjaan
Nama penyedia
Logo penyedia
Rating penyedia
Jumlah review penyedia
Kategori
Lokasi
Gaji/upah
Tipe gaji
Jadwal kerja
Kuota tersedia
Batas akhir lamaran
Deskripsi pekerjaan
Syarat pekerjaan
Review penyedia dari mahasiswa lain
Button Lamar
Button Simpan Favorit
```

Validasi tombol Lamar secara tampilan:

```txt
Akun belum diverifikasi → tombol disabled
Belum upload CV → arahkan upload CV
Sudah pernah melamar → tombol Lihat Lamaran
Kuota penuh → tombol disabled
Lowongan ditutup → tombol disabled
```

### 16.7 Lowongan Favorit

Route:

```txt
/mahasiswa/favorites
```

Isi halaman:

```txt
Daftar lowongan favorit
Search
Filter kategori
Hapus dari favorit
Lihat detail lowongan
```

Data yang tampil:

```txt
Nama pekerjaan
Penyedia
Lokasi
Gaji
Jadwal
Status lowongan
Tanggal disimpan
```

### 16.8 Lamaran Saya

Route:

```txt
/mahasiswa/applications
```

Fitur:

```txt
Search
Filter status
Filter tanggal
Filter penyedia
Pagination
```

Kolom/card data:

```txt
Nama lowongan
Nama penyedia
Tanggal melamar
Status lamaran
Status review
Aksi
```

Aksi:

```txt
Lihat detail
Batalkan lamaran
Beri review jika pekerjaan selesai
```

Di mobile:

```txt
Gunakan card lamaran, bukan table penuh.
```

### 16.9 Detail Lamaran

Route:

```txt
/mahasiswa/applications/{id}
```

Isi halaman:

```txt
Data lowongan
Data penyedia
CV yang dikirim
Tanggal melamar
Status lamaran
Timeline status lamaran
Catatan penyedia
Review penyedia ke mahasiswa
Review mahasiswa ke penyedia
```

Timeline contoh:

```txt
Lamaran dikirim
Lamaran dilihat penyedia
Lamaran diproses
Lamaran diterima
Pekerjaan selesai
Review diberikan
```

Aksi:

```txt
Batalkan lamaran
Download CV yang dikirim
Beri review penyedia
Lihat review dari penyedia
```

Tombol Beri Review Penyedia hanya muncul jika:

```txt
Status lamaran = Selesai
Mahasiswa belum pernah memberi review untuk lamaran ini
```

### 16.10 Review Mahasiswa

Route:

```txt
/mahasiswa/reviews
```

Isi halaman:

```txt
Rating rata-rata mahasiswa
Jumlah review diterima
Tab review diterima
Tab review diberikan
```

Review diterima dari penyedia:

```txt
Nama penyedia
Nama lowongan
Rating
Komentar
Tanggal review
```

Review diberikan ke penyedia:

```txt
Nama penyedia
Nama lowongan
Rating
Komentar saya
Tanggal review
```

### 16.11 Profil Mahasiswa

Route:

```txt
/mahasiswa/profile
```

Bagian halaman:

```txt
Data Akun
Data Mahasiswa
Dokumen
Status Verifikasi
Keamanan Akun
```

Data akun:

```txt
Nama lengkap
Email
Username
Nomor telepon
Foto profil
```

Data mahasiswa:

```txt
Nama kampus
Jurusan
Semester
Alamat
Keahlian
Pengalaman kerja opsional
```

Dokumen:

```txt
Upload CV
Upload KTM
Preview CV
Preview KTM
```

Status verifikasi:

```txt
Belum Upload Dokumen
Menunggu Verifikasi
Terverifikasi
Ditolak
```

Jika ditolak:

```txt
Tampilkan alasan penolakan.
Tampilkan upload ulang KTM.
Tampilkan tombol kirim ulang verifikasi.
```

Keamanan akun:

```txt
Ubah password
Logout
```

---

## 17. Navigation Structure

### 17.1 Navbar Public

```txt
Beranda
Lowongan
Cara Kerja
Masuk
Daftar
```

Button utama:

```txt
Cari Lowongan
Pasang Lowongan
```

### 17.2 Sidebar Admin

```txt
Dashboard
Verifikasi Akun
Verifikasi Lowongan
Manajemen Pengguna
Manajemen Kategori
Manajemen Lowongan
Manajemen Lamaran
Laporan
Profil
Logout
```

### 17.3 Sidebar Penyedia

```txt
Dashboard
Profil Usaha
Lowongan
Lamaran Masuk
Review
Profil Akun
Logout
```

Submenu Lowongan:

```txt
Daftar Lowongan
Tambah Lowongan
```

### 17.4 Navigation Mahasiswa

Karena mahasiswa mobile first, gunakan bottom navigation di mobile.

Menu mahasiswa:

```txt
Dashboard
Lowongan
Favorit
Lamaran
Review
Profil
```

Untuk desktop, menu bisa menjadi sidebar atau top navigation.

---

## 18. Review Feature Detail

Review diberikan dua arah:

```txt
Mahasiswa memberi review ke penyedia.
Penyedia memberi review ke mahasiswa.
```

Form review:

```txt
Rating 1 sampai 5
Komentar
Button kirim review
```

Review card berisi:

```txt
Nama pemberi review
Role pemberi review
Nama lowongan
Rating
Komentar
Tanggal review
```

Aturan tampilan:

```txt
1. Jika status lamaran belum selesai, tampilkan pesan bahwa review belum tersedia.
2. Jika status lamaran selesai dan belum review, tampilkan tombol beri review.
3. Jika sudah review, tampilkan review yang sudah diberikan.
4. Review hanya muncul pada data dummy yang relevan dengan lamaran selesai.
```

---

## 19. Upload UI

Karena frontend saja, upload tidak perlu berfungsi nyata. Namun UI upload tetap harus dibuat.

Jenis upload:

```txt
KTM mahasiswa
CV mahasiswa
Logo usaha
Dokumen verifikasi penyedia
```

Komponen upload harus memiliki:

```txt
Upload area
Nama file dummy
Preview file dummy
Button ganti file
Info format file
Info maksimal ukuran file
```

Format file yang ditampilkan:

```txt
CV: PDF, DOC, DOCX
KTM: JPG, PNG, PDF
Logo usaha: JPG, PNG
Dokumen verifikasi: PDF, JPG, PNG
```

---

## 20. Chart

Gunakan Chart.js untuk:

```txt
1. Dashboard admin - grafik jumlah lowongan per bulan.
2. Dashboard admin - grafik jumlah pelamar per bulan.
3. Dashboard penyedia - grafik lamaran masuk per bulan.
```

Chart cukup menggunakan dummy data.

---

## 21. Table, Search, Filter, dan Pagination

Semua halaman table harus memiliki UI berikut jika relevan:

```txt
Search
Filter
Pagination
Action dropdown atau action button
Status badge
Empty state
```

Halaman yang menggunakan table:

```txt
Admin Verifikasi Akun
Admin Verifikasi Lowongan
Admin Manajemen Pengguna
Admin Manajemen Kategori
Admin Manajemen Lowongan
Admin Manajemen Lamaran
Admin Laporan
Penyedia Daftar Lowongan
Penyedia Lamaran Masuk
Penyedia Review
Mahasiswa desktop Lamaran Saya
Mahasiswa desktop Favorit
```

Untuk mahasiswa mobile, data utama sebaiknya menggunakan card.

---

## 22. Modal dan Toast

### 22.1 Toast Custom

Toast digunakan untuk:

```txt
Berhasil login
Berhasil menyimpan data
Berhasil menghapus data
Berhasil mengirim review
Gagal validasi form
```

Toast harus reusable dan bisa dipakai di semua halaman.

### 22.2 Confirm Modal

Confirm modal digunakan untuk:

```txt
Hapus data
Batalkan lamaran
Tutup lowongan
Tolak verifikasi
Tolak lowongan
Logout
```

Jangan gunakan:

```txt
alert()
confirm()
prompt()
```

---

## 23. Final Pages List

### 23.1 Public

```txt
/
/lowongan
/lowongan/{id}
/register
/register/mahasiswa
/register/penyedia
/login
/forgot-password
/reset-password
```

### 23.2 Admin

```txt
/admin/login
/admin/dashboard
/admin/verifikasi-akun
/admin/verifikasi-lowongan
/admin/users
/admin/categories
/admin/jobs
/admin/applications
/admin/reports
/admin/profile
```

### 23.3 Penyedia

```txt
/penyedia/dashboard
/penyedia/profil-usaha
/penyedia/jobs
/penyedia/jobs/create
/penyedia/jobs/{id}
/penyedia/jobs/{id}/edit
/penyedia/applications
/penyedia/applications/{id}
/penyedia/reviews
/penyedia/profile
```

Catatan:

```txt
Register penyedia menggunakan /register/penyedia.
Login penyedia menggunakan /login.
```

### 23.4 Mahasiswa

```txt
/mahasiswa/dashboard
/mahasiswa/jobs
/mahasiswa/jobs/{id}
/mahasiswa/favorites
/mahasiswa/applications
/mahasiswa/applications/{id}
/mahasiswa/reviews
/mahasiswa/profile
```

Catatan:

```txt
Register mahasiswa menggunakan /register/mahasiswa.
Login mahasiswa menggunakan /login.
```

---

## 24. Ringkasan Jumlah Pages

```txt
Public     : 9 pages
Admin      : 10 pages
Penyedia   : 12 pages termasuk register dan login public
Mahasiswa  : 10 pages termasuk register dan login public
```

Jika dihitung route unik utama:

```txt
Public route utama      : 9
Admin route utama       : 10
Penyedia dashboard area : 10
Mahasiswa dashboard area: 8
```

---

## 25. Output Akhir yang Harus Dihasilkan

Project frontend harus menghasilkan:

```txt
1. Laravel 13 project yang bisa dijalankan.
2. Tailwind CSS v4 terpasang.
3. Struktur layout Blade rapi.
4. Route public lengkap.
5. Route admin lengkap.
6. Route penyedia lengkap.
7. Route mahasiswa lengkap.
8. Controller untuk semua halaman.
9. Komponen Blade reusable.
10. Dummy data digunakan di halaman.
11. Semua halaman public selesai.
12. Semua halaman admin selesai.
13. Semua halaman penyedia selesai.
14. Semua halaman mahasiswa selesai.
15. Mahasiswa mobile first.
16. Admin responsive.
17. Penyedia responsive.
18. Toast custom tersedia.
19. Confirm modal custom tersedia.
20. Chart dummy tersedia.
21. UI sesuai palette.
22. Tidak ada emoji di UI.
23. Tidak ada gradient.
24. Tidak ada bubble UI.
25. Tidak menggunakan alert/confirm/prompt bawaan JavaScript.
```

---

## 26. Catatan Penting untuk AI Builder

```txt
1. Selalu jadikan file brief.md ini sebagai patokan utama.
2. Jangan menambahkan fitur di luar brief tanpa alasan kuat.
3. Jangan mengubah color palette.
4. Jangan menggunakan gradient.
5. Jangan menggunakan emoji.
6. Jangan menggunakan rounded besar seperti rounded-xl atau rounded-2xl.
7. Gunakan rounded-md.
8. Gunakan dummy data.
9. Jangan membuat database.
10. Jangan membuat migration.
11. Jangan membuat API.
12. Tetap buat route dan controller.
13. Semua halaman harus bisa dibuka lewat browser.
14. Semua aksi frontend harus memberi feedback menggunakan toast/modal.
15. Mahasiswa harus mobile first.
16. Admin dan penyedia tetap harus responsive.
17. Jika ada kebutuhan data, ambil dari dummy-data.json.
18. Jika dummy-data.json belum ada, gunakan dummy data sementara yang mudah diganti.
```
