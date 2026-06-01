# Task Frontend Website Part Time

## Tujuan Task

Dokumen ini berisi daftar task untuk mengerjakan frontend website part time menggunakan Laravel 13 dan Tailwind CSS v4. Project ini hanya berfokus pada frontend, tetapi tetap harus membuat route dan controller agar aplikasi bisa dijalankan dan dinavigasi seperti aplikasi nyata menggunakan dummy data.

Semua pengerjaan harus mengacu pada:

```txt
1. brief.md sebagai patokan utama requirement, flow, pages, UI rules, dan scope.
2. dummy-data.json sebagai sumber data dummy untuk controller dan view.
```

## Scope Project

Project yang dibuat adalah frontend website part time dengan role:

```txt
1. Public user / guest
2. Admin
3. Mahasiswa / Pelamar
4. Penyedia Part Time
```

Frontend harus mencakup:

```txt
1. Public pages
2. Admin pages
3. Mahasiswa pages
4. Penyedia pages
5. Dummy controller
6. Dummy route
7. Dummy data integration
8. Reusable Blade components
9. Custom toast
10. Custom confirm modal
11. Chart.js dummy chart
12. Responsive UI
13. Mobile first UI untuk mahasiswa
```

## Output Akhir yang Diharapkan

Setelah semua task selesai, aplikasi harus bisa:

```txt
1. Dijalankan sebagai aplikasi Laravel.
2. Menggunakan Tailwind CSS v4 yang di-install.
3. Menampilkan semua halaman sesuai brief.md.
4. Menggunakan dummy-data.json sebagai sumber data utama.
5. Navigasi antar halaman berjalan dengan route Laravel.
6. Controller mengirim dummy data ke view.
7. Semua table, card, chart, review, status, dan form tampil rapi.
8. Admin dan penyedia nyaman digunakan di desktop.
9. Mahasiswa menggunakan desain mobile first tetapi tetap bagus di desktop.
10. Toast dan confirm modal custom tersedia.
11. Tidak menggunakan alert, confirm, prompt bawaan JavaScript.
12. Tidak menggunakan emoji, gradient, dan bubble UI.
13. UI konsisten dengan color palette dan rules di brief.md.
```

---

# 25 Task Pengerjaan Frontend

## Task 1 - Setup Project Laravel 13 dan Struktur Awal

Buat project Laravel 13 dan siapkan struktur awal frontend.

Pekerjaan:

```txt
1. Install Laravel 13.
2. Setup Vite.
3. Install Tailwind CSS v4.
4. Pastikan asset CSS dan JS berjalan.
5. Buat struktur folder Blade untuk public, admin, mahasiswa, penyedia, layouts, components, dan partials.
```

Struktur folder yang disarankan:

```txt
resources/views/
├── layouts/
├── components/
├── partials/
├── public/
├── admin/
├── mahasiswa/
└── penyedia/
```

Yang perlu dites:

```txt
1. Laravel bisa dijalankan.
2. Tailwind class berjalan.
3. Halaman test bisa tampil.
```

---

## Task 2 - Setup Theme, Font, Icon, dan Base Style

Buat konfigurasi style global sesuai brief.md.

Pekerjaan:

```txt
1. Gunakan font Inter.
2. Setup FontAwesome untuk icon.
3. Buat variable warna atau utility class sesuai color palette.
4. Buat base style untuk body, heading, link, form, table, dan scrollbar jika diperlukan.
5. Pastikan tidak ada gradient, emoji, dan bubble UI.
```

Color palette:

```txt
Primary    : #1E3A8A
Secondary  : #FBBF24
Accent     : #FBBF24
Background : #FFFFFF
Text Dark  : #111827
Text Gray  : #6B7280
Border     : #E5E7EB
Surface    : #F9FAFB
```

Yang perlu dites:

```txt
1. Font Inter aktif.
2. FontAwesome icon tampil.
3. Warna utama konsisten.
4. Rounded hanya menggunakan rounded-md.
```

---

## Task 3 - Integrasi dummy-data.json

Buat mekanisme membaca dummy-data.json agar bisa dipakai oleh controller.

Pekerjaan:

```txt
1. Simpan dummy-data.json di lokasi yang mudah dibaca, misalnya storage/app/dummy-data.json atau resources/data/dummy-data.json.
2. Buat helper/service sederhana untuk membaca JSON.
3. Pastikan controller bisa mengambil data kategori, users, jobs, applications, reviews, dan dashboard.
4. Jangan gunakan database.
```

Yang perlu dites:

```txt
1. JSON bisa dibaca tanpa error.
2. Data bisa dikirim dari controller ke Blade.
3. Jika data kosong, view tetap aman dan tidak error.
```

---

## Task 4 - Buat Route Utama Semua Role

Buat route untuk public, admin, mahasiswa, dan penyedia.

Pekerjaan:

```txt
1. Buat route public.
2. Buat route admin.
3. Buat route mahasiswa.
4. Buat route penyedia.
5. Route harus mengarah ke controller, bukan closure penuh.
```

Route public:

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

Route admin:

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

Route mahasiswa:

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

Route penyedia:

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

Yang perlu dites:

```txt
1. Semua route bisa diakses.
2. Route detail dengan ID dummy tidak error.
3. Route yang tidak ada menampilkan 404 Laravel normal.
```

---

## Task 5 - Buat Controller Frontend

Buat controller untuk setiap area aplikasi.

Controller yang disarankan:

```txt
App\Http\Controllers\PublicController
App\Http\Controllers\AdminController
App\Http\Controllers\MahasiswaController
App\Http\Controllers\PenyediaController
```

Pekerjaan:

```txt
1. Setiap method controller mengirim data dummy ke view.
2. Controller tidak perlu menyimpan data.
3. Form action boleh dummy.
4. Untuk tombol aksi gunakan redirect dummy atau toast.
```

Yang perlu dites:

```txt
1. Controller mengirim data sesuai halaman.
2. Halaman detail dapat membaca data berdasarkan ID dummy.
3. Jika ID tidak ditemukan, tampilkan halaman/detail empty state atau abort 404.
```

---

## Task 6 - Buat Layout Public

Buat layout utama untuk halaman public.

Pekerjaan:

```txt
1. Buat public layout dengan navbar dan footer.
2. Navbar berisi Beranda, Lowongan, Cara Kerja, Masuk, Daftar.
3. Buat hamburger menu untuk mobile.
4. Gunakan button utama Cari Lowongan dan Pasang Lowongan.
```

Yang perlu dites:

```txt
1. Navbar desktop rapi.
2. Navbar mobile bisa dibuka/tutup.
3. Footer tampil di semua halaman public.
```

---

## Task 7 - Buat Layout Admin

Buat layout dashboard admin.

Pekerjaan:

```txt
1. Buat sidebar admin.
2. Buat topbar admin.
3. Buat area content.
4. Sidebar mobile menjadi drawer.
5. Highlight menu aktif berdasarkan route.
```

Menu admin:

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

Yang perlu dites:

```txt
1. Sidebar desktop tampil rapi.
2. Sidebar mobile bisa dibuka.
3. Active state menu berjalan.
```

---

## Task 8 - Buat Layout Penyedia

Buat layout dashboard penyedia.

Pekerjaan:

```txt
1. Buat sidebar penyedia.
2. Buat topbar penyedia.
3. Buat area content.
4. Sidebar mobile menjadi drawer.
5. Tambahkan submenu Lowongan.
```

Menu penyedia:

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

Yang perlu dites:

```txt
1. Menu penyedia tampil konsisten.
2. Submenu lowongan bisa tampil.
3. Layout responsive.
```

---

## Task 9 - Buat Layout Mahasiswa Mobile First

Buat layout mahasiswa dengan pendekatan mobile first.

Pekerjaan:

```txt
1. Buat topbar sederhana untuk mahasiswa.
2. Buat bottom navigation di mobile.
3. Buat sidebar atau top navigation untuk desktop.
4. Pastikan semua halaman mahasiswa nyaman dibuka di mobile.
```

Menu mahasiswa:

```txt
Dashboard
Lowongan
Favorit
Lamaran
Review
Profil
```

Yang perlu dites:

```txt
1. Mobile 360px tetap rapi.
2. Bottom navigation tidak menutupi konten.
3. Desktop tetap terlihat profesional.
```

---

## Task 10 - Buat Reusable Component Dasar

Buat Blade component dasar untuk UI.

Komponen wajib:

```txt
Button
Input
Textarea
Select
Checkbox
Card
Badge
Status Badge
Modal
Confirm Modal
Toast
Table
Pagination
Search Input
Filter Dropdown
File Upload
Empty State
Loading State
Tabs
```

Yang perlu dites:

```txt
1. Component bisa dipakai lintas halaman.
2. Props component mudah digunakan.
3. Style component konsisten.
```

---

## Task 11 - Buat Component Khusus Aplikasi

Buat component yang spesifik untuk aplikasi part time.

Komponen khusus:

```txt
Dashboard Summary Card
Chart Card
Job Card
Application Card
Review Card
Application Status Timeline
Verification Status Panel
Upload Document Card
Profile Section Card
```

Yang perlu dites:

```txt
1. Job card tampil bagus di mobile dan desktop.
2. Review card menampilkan rating dan komentar.
3. Timeline status lamaran mudah dibaca.
```

---

## Task 12 - Buat Public Landing Page

Buat halaman landing page di route `/`.

Section yang harus ada:

```txt
Navbar
Hero section
Statistik singkat
Kategori pekerjaan
Lowongan terbaru
Cara kerja aplikasi
Keunggulan platform
CTA daftar mahasiswa
CTA daftar penyedia
Footer
```

Yang perlu dites:

```txt
1. CTA Cari Lowongan menuju /lowongan.
2. CTA Pasang Lowongan menuju /register/penyedia.
3. Lowongan terbaru mengambil dummy jobs aktif.
4. Tampilan mobile dan desktop rapi.
```

---

## Task 13 - Buat Public Lowongan dan Detail Lowongan

Buat halaman `/lowongan` dan `/lowongan/{id}`.

Pekerjaan halaman `/lowongan`:

```txt
1. Tampilkan daftar lowongan aktif.
2. Gunakan search input dummy.
3. Gunakan filter kategori, lokasi, jadwal, dan gaji dummy.
4. Gunakan pagination dummy.
5. Gunakan job card.
```

Pekerjaan halaman `/lowongan/{id}`:

```txt
1. Tampilkan detail lowongan.
2. Tampilkan penyedia, logo, rating, dan jumlah review.
3. Tampilkan deskripsi dan syarat pekerjaan.
4. Tampilkan review penyedia.
5. Tampilkan lowongan serupa.
6. Button Lamar Sekarang mengarah ke /login.
```

Yang perlu dites:

```txt
1. Hanya status Aktif yang tampil di daftar public.
2. Detail lowongan tidak error.
3. Mobile layout rapi.
```

---

## Task 14 - Buat Public Auth Pages

Buat halaman register, login, forgot password, dan reset password.

Pages:

```txt
/register
/register/mahasiswa
/register/penyedia
/login
/forgot-password
/reset-password
```

Pekerjaan:

```txt
1. /register menampilkan pilihan role.
2. /register/mahasiswa menampilkan form registrasi mahasiswa.
3. /register/penyedia menampilkan form registrasi penyedia.
4. /login menampilkan form login mahasiswa/penyedia.
5. /forgot-password menampilkan form input email.
6. /reset-password menampilkan form password baru.
```

Yang perlu dites:

```txt
1. Form responsive.
2. Upload KTM dan dokumen penyedia hanya berupa UI dummy.
3. Button submit menampilkan toast dummy.
```

---

## Task 15 - Buat Admin Login dan Dashboard

Buat halaman `/admin/login` dan `/admin/dashboard`.

Dashboard admin harus menampilkan:

```txt
1. Summary card total mahasiswa terdaftar.
2. Summary card total penyedia lowongan.
3. Summary card total lowongan aktif.
4. Summary card total lamaran masuk.
5. Data ringkas mahasiswa menunggu verifikasi.
6. Data ringkas penyedia menunggu verifikasi.
7. Data ringkas lowongan menunggu review.
8. Data ringkas lamaran diterima bulan ini.
9. Chart jumlah lowongan per bulan.
10. Chart jumlah pelamar per bulan.
11. Table 5 lamaran terbaru.
12. Table 5 akun menunggu verifikasi.
13. Table 5 lowongan menunggu review.
```

Yang perlu dites:

```txt
1. Chart.js tampil.
2. Summary card responsive.
3. Table tidak pecah di mobile.
```

---

## Task 16 - Buat Admin Verifikasi Akun dan Verifikasi Lowongan

Buat halaman:

```txt
/admin/verifikasi-akun
/admin/verifikasi-lowongan
```

Verifikasi akun:

```txt
1. Tab Mahasiswa dan Penyedia.
2. Table akun pending.
3. Search dan filter status.
4. Detail akun dalam modal atau panel.
5. Preview dokumen dummy.
6. Button approve.
7. Button reject dengan input alasan.
```

Verifikasi lowongan:

```txt
1. Table lowongan menunggu review.
2. Search dan filter.
3. Detail lowongan dalam modal atau panel.
4. Button approve.
5. Button reject dengan input alasan.
```

Yang perlu dites:

```txt
1. Approve/reject menampilkan toast dummy.
2. Reject menggunakan modal custom.
3. Tidak menggunakan confirm bawaan JavaScript.
```

---

## Task 17 - Buat Admin Manajemen Data

Buat halaman:

```txt
/admin/users
/admin/categories
/admin/jobs
/admin/applications
```

Manajemen pengguna:

```txt
Table pengguna, search, filter role, filter status, detail, edit, nonaktifkan, hapus.
```

Manajemen kategori:

```txt
Table kategori, tambah, edit, hapus, aktif/nonaktif, search.
```

Manajemen lowongan:

```txt
Table lowongan, search, filter kategori, filter penyedia, filter status, detail, tambah, edit, hapus, ubah status.
```

Manajemen lamaran:

```txt
Table lamaran, search, filter status, filter lowongan, filter penyedia, filter tanggal, detail, update status, timeline, review dua arah.
```

Yang perlu dites:

```txt
1. Semua table menampilkan dummy data.
2. Action button membuka modal/toast dummy.
3. Status badge tampil sesuai status.
```

---

## Task 18 - Buat Admin Laporan dan Profil

Buat halaman:

```txt
/admin/reports
/admin/profile
```

Laporan:

```txt
1. Laporan data mahasiswa.
2. Laporan data penyedia.
3. Laporan data lowongan.
4. Laporan data lamaran.
5. Laporan verifikasi akun.
6. Laporan lowongan aktif.
7. Laporan lowongan selesai.
8. Laporan review.
9. Filter tanggal, role, status, kategori.
10. Button export PDF dummy.
11. Button export Excel dummy.
12. Button print dummy.
```

Profil admin:

```txt
1. Edit nama.
2. Edit email.
3. Edit username.
4. Ubah password.
5. Logout dummy.
```

Yang perlu dites:

```txt
1. Filter tampil rapi.
2. Button export menampilkan toast dummy.
3. Form profil responsive.
```

---

## Task 19 - Buat Penyedia Dashboard dan Profil Usaha

Buat halaman:

```txt
/penyedia/dashboard
/penyedia/profil-usaha
```

Dashboard penyedia:

```txt
1. Jumlah lowongan aktif.
2. Jumlah lowongan menunggu review.
3. Jumlah lamaran masuk.
4. Jumlah pelamar diterima.
5. Rating penyedia.
6. Chart lamaran masuk per bulan.
7. Table 5 lamaran terbaru.
8. Table 5 lowongan terbaru.
9. Shortcut tambah lowongan, lihat lamaran, kelola profil usaha.
10. Banner akun menunggu verifikasi jika status dummy belum verified.
```

Profil usaha:

```txt
1. Nama usaha / instansi.
2. Jenis usaha.
3. Logo usaha.
4. Nomor telepon usaha.
5. Email usaha.
6. Alamat usaha.
7. Deskripsi usaha.
8. Dokumen verifikasi.
9. Status verifikasi.
10. Alasan ditolak jika ada.
11. Upload ulang dokumen dummy.
```

Yang perlu dites:

```txt
1. Chart tampil.
2. Banner verifikasi tampil sesuai dummy data.
3. Upload UI tampil tanpa backend.
```

---

## Task 20 - Buat Penyedia Manajemen Lowongan

Buat halaman:

```txt
/penyedia/jobs
/penyedia/jobs/create
/penyedia/jobs/{id}
/penyedia/jobs/{id}/edit
```

Daftar lowongan:

```txt
Table lowongan, search, filter status, filter kategori, button tambah lowongan, aksi detail, edit, tutup, hapus.
```

Tambah lowongan:

```txt
Form nama pekerjaan, kategori, deskripsi, syarat, lokasi, gaji, tipe gaji, jadwal, tanggal mulai, tanggal akhir, kuota, batas akhir lamaran, kontak tambahan.
```

Detail lowongan:

```txt
Detail informasi lowongan, status review admin, alasan reject, jumlah pelamar, jumlah diterima, jumlah ditolak, daftar pelamar terbaru.
```

Edit lowongan:

```txt
Form edit lowongan, preview status, info bahwa perubahan dapat memerlukan review ulang.
```

Yang perlu dites:

```txt
1. Form tampil rapi.
2. Status lowongan tampil dengan badge.
3. Action tutup/hapus menggunakan modal custom.
```

---

## Task 21 - Buat Penyedia Lamaran Masuk dan Detail Lamaran

Buat halaman:

```txt
/penyedia/applications
/penyedia/applications/{id}
```

Lamaran masuk:

```txt
1. Table lamaran.
2. Search nama mahasiswa.
3. Filter lowongan.
4. Filter status lamaran.
5. Filter tanggal.
6. Detail lamaran.
7. Update status lamaran dummy.
```

Detail lamaran:

```txt
1. Data mahasiswa.
2. Nama lowongan yang dilamar.
3. Tanggal melamar.
4. CV yang dikirim.
5. Catatan mahasiswa.
6. Status lamaran.
7. Catatan penyedia.
8. Timeline status lamaran.
9. Review mahasiswa ke penyedia.
10. Review penyedia ke mahasiswa.
11. Button diproses, terima, tolak, tandai selesai, download CV, beri review.
```

Yang perlu dites:

```txt
1. Tombol beri review hanya tampil jika status selesai.
2. KTM mahasiswa tidak ditampilkan ke penyedia.
3. Timeline status tampil rapi.
```

---

## Task 22 - Buat Penyedia Review dan Profil Akun

Buat halaman:

```txt
/penyedia/reviews
/penyedia/profile
```

Review penyedia:

```txt
1. Rating rata-rata penyedia.
2. Jumlah review diterima.
3. Tab review diterima.
4. Tab review diberikan.
5. Review card.
```

Profil akun penyedia:

```txt
1. Edit nama penanggung jawab.
2. Edit email.
3. Edit username.
4. Edit nomor telepon.
5. Ubah password.
6. Logout dummy.
```

Yang perlu dites:

```txt
1. Review diterima dan diberikan terpisah.
2. Rating tampil konsisten.
3. Form profil responsive.
```

---

## Task 23 - Buat Mahasiswa Dashboard, Lowongan, dan Detail Lowongan

Buat halaman:

```txt
/mahasiswa/dashboard
/mahasiswa/jobs
/mahasiswa/jobs/{id}
```

Dashboard mahasiswa:

```txt
1. Lowongan tersedia.
2. Total lamaran saya.
3. Lamaran diproses.
4. Lamaran diterima.
5. Rating saya.
6. Lowongan terbaru.
7. Status lamaran terakhir.
8. Review terbaru yang diterima.
```

Lowongan mahasiswa:

```txt
1. Search lowongan.
2. Filter kategori, lokasi, jadwal, gaji, status.
3. Simpan favorit dummy.
4. Pagination dummy.
5. Gunakan card layout di mobile.
6. Filter mobile lewat drawer/modal.
```

Detail lowongan:

```txt
1. Detail pekerjaan.
2. Data penyedia.
3. Logo penyedia.
4. Rating penyedia.
5. Review penyedia.
6. Button Lamar.
7. Button Simpan Favorit.
8. Disabled state untuk akun belum verified, belum upload CV, kuota penuh, sudah melamar, dan lowongan ditutup.
```

Yang perlu dites:

```txt
1. Mobile first benar-benar nyaman.
2. Lowongan tampil sebagai card di mobile.
3. Desktop tetap bagus.
```

---

## Task 24 - Buat Mahasiswa Favorit, Lamaran, Review, dan Profil

Buat halaman:

```txt
/mahasiswa/favorites
/mahasiswa/applications
/mahasiswa/applications/{id}
/mahasiswa/reviews
/mahasiswa/profile
```

Favorit:

```txt
Daftar lowongan favorit, search, filter kategori, hapus dari favorit, lihat detail.
```

Lamaran saya:

```txt
Search, filter status, filter tanggal, filter penyedia, pagination, card mobile, table desktop.
```

Detail lamaran:

```txt
Data lowongan, data penyedia, CV yang dikirim, tanggal melamar, status lamaran, timeline, catatan penyedia, review dua arah, button beri review.
```

Review mahasiswa:

```txt
Rating rata-rata mahasiswa, jumlah review diterima, tab review diterima, tab review diberikan.
```

Profil mahasiswa:

```txt
Data akun, data mahasiswa, dokumen, status verifikasi, keamanan akun, upload CV, upload KTM, preview dokumen, alasan penolakan jika ada.
```

Yang perlu dites:

```txt
1. Semua halaman mobile first.
2. Bottom navigation tetap nyaman.
3. Upload UI tampil tanpa backend.
4. Review hanya muncul untuk lamaran selesai.
```

---

## Task 25 - Final Polish, Responsive Testing, dan Quality Check

Lakukan pengecekan akhir semua halaman dan komponen.

Pekerjaan:

```txt
1. Cek semua route.
2. Cek semua controller.
3. Cek semua halaman public.
4. Cek semua halaman admin.
5. Cek semua halaman penyedia.
6. Cek semua halaman mahasiswa.
7. Cek dummy-data.json digunakan konsisten.
8. Cek toast custom.
9. Cek confirm modal custom.
10. Cek tidak ada alert, confirm, prompt bawaan JavaScript.
11. Cek tidak ada emoji di UI.
12. Cek tidak ada gradient.
13. Cek tidak ada bubble UI.
14. Cek rounded tidak berlebihan dan memakai rounded-md.
15. Cek color palette konsisten.
16. Cek chart tampil.
17. Cek table responsive.
18. Cek mobile mahasiswa.
19. Cek desktop admin dan penyedia.
20. Cek empty state.
21. Cek loading state jika ada.
22. Cek form spacing dan validation dummy.
23. Cek button hover/focus state.
24. Cek accessibility dasar seperti label input dan focus ring.
25. Rapikan kode dan hapus file yang tidak dipakai.
```

Breakpoint yang wajib dicek:

```txt
Mobile kecil : 360px
Mobile umum  : 390px
Tablet       : 768px
Laptop       : 1024px
Desktop      : 1280px
```

Checklist final:

```txt
1. Aplikasi bisa dijalankan.
2. Semua halaman bisa dibuka.
3. Tidak ada error console besar.
4. Tidak ada broken layout utama.
5. Semua data berasal dari dummy-data.json.
6. Semua flow utama bisa disimulasikan secara frontend.
7. Hasil akhir sesuai brief.md.
```

---

# Catatan Penting untuk AI Builder

```txt
1. Jangan keluar dari brief.md.
2. Jangan membuat backend database.
3. Jangan membuat migration.
4. Jangan membuat API.
5. Tetap buat route dan controller Laravel.
6. Gunakan dummy-data.json untuk data.
7. Jangan hardcode data terlalu banyak di Blade jika data sudah tersedia di dummy-data.json.
8. Semua form boleh dummy, tetapi tampilannya harus lengkap.
9. Semua action boleh menampilkan toast atau modal.
10. Semua halaman harus terlihat seperti aplikasi yang siap digunakan.
11. Prioritaskan kualitas UI, konsistensi komponen, dan responsive layout.
12. Mahasiswa harus mobile first.
13. Admin dan penyedia harus nyaman di desktop.
```

