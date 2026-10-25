# SKENA — Sistem Informasi Kumpulan Edukasi Narkotika
### Badan Narkotika Nasional Provinsi (BNNP) Sulawesi Tengah

Platform digital resmi Badan Narkotika Nasional Provinsi (BNNP) Sulawesi Tengah yang mengintegrasikan pemetaan geografis zonasi kerawanan narkotika, pusat literasi edukasi pencegahan, publikasi statistik kasus, gamifikasi edukatif, serta kanal informasi layanan rehabilitasi dan pelaporan masyarakat guna mendukung program Pencegahan, Pemberantasan Penyalahgunaan, dan Peredaran Gelap Narkotika (P4GN) di Provinsi Sulawesi Tengah.

---

## Daftar Isi

1. [Tentang Sistem](#tentang-sistem)
2. [Fitur Utama](#fitur-utama)
3. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
4. [Persyaratan Sistem](#persyaratan-sistem)
5. [Panduan Instalasi](#panduan-instalasi)
6. [Kredensial Pengujian](#kredensial-pengujian)
7. [Struktur Direktori](#struktur-direktori)
8. [Daftar Rute dan API](#daftar-rute-dan-api)
9. [Hak Akses dan Peran (RBAC)](#hak-akses-dan-peran-rbac)
10. [Panduan Import Dataset CSV](#panduan-import-dataset-csv)
11. [Pemeliharaan dan Troubleshooting](#pemeliharaan-dan-troubleshooting)
12. [Kontak dan Saluran Resmi](#kontak-dan-saluran-resmi)

---

## Tentang Sistem

SKENA (*Sistem Informasi Kumpulan Edukasi Narkotika*) dirancang sebagai instrumen digital terpadu BNNP Sulawesi Tengah dalam menyebarluaskan informasi bahaya penyalahgunaan narkotika kepada masyarakat luas, memfasilitasi keterbukaan data sebaran tingkat kerawanan wilayah secara transparan, serta mengedukasi publik terkait prosedur rehabilitasi medis dan sosial yang bersifat sukarela, gratis, dan bebas pidana sebagaimana diamanatkan dalam Undang-Undang Republik Indonesia Nomor 35 Tahun 2009 tentang Narkotika.

---

## Fitur Utama

### 1. Portal Publik

- **Beranda Interaktif**: Ringkasan data statistik makro (total kasus, zonasi wilayah, total edukasi, dan riwayat pengunjung), tautan cepat layanan darurat, serta banner komitmen Sulawesi Tengah Bersinar.
- **Peta Interaktif Zonasi Kerawanan (GIS)**:
  - Visualisasi poligon batas wilayah 13 Kabupaten/Kota dan Kecamatan se-Provinsi Sulawesi Tengah berbasis Leaflet.js dan format GeoJSON.
  - Klasifikasi status zona: Zona Merah (Bahaya / Kerawanan Tinggi), Zona Kuning (Waspada / Kerawanan Sedang), dan Zona Hijau (Aman / Kerawanan Rendah).
  - Filter interaktif berdasarkan status zonasi dan hierarki wilayah (Kabupaten, Kecamatan, Kelurahan).
  - Pop-up ringkasan wilayah yang menyajikan data nama wilayah, kode daerah, jumlah kasus tercatat, dan deskripsi wilayah.
- **Katalog Edukasi dan Literasi P4GN**:
  - Artikel ilmiah dan ulasan bahaya berbagai golongan zat narkotika/adiktif.
  - Kamus dan glosarium istilah narkotika.
  - Media infografis dan visualisasi edukasi.
  - Callout edukasi layanan rehabilitasi mandiri rahasia dan aman.
- **Visualisasi Statistik Kasus**:
  - Penyajian grafik dan data agregat sebaran kasus pada 3 pilar: Rehabilitasi, Pencegahan dan Pemberdayaan Masyarakat (P2M), serta Pemberantasan.
  - Rincian demografi mencakup kelompok umur, jenis kelamin, jenis zat narkotika, dan latar belakang pekerjaan.
- **Mini Games Edukatif (Gamifikasi)**:
  - **Wordle Narkotika**: Permainan tebak kata 5-6 huruf seputar regulasi, adiksi, dan pemulihan narkotika dengan sistem petunjuk dan indikator warna.
  - **Mitos vs Fakta**: Kuis verifikasi pernyataan populer mengenai narkotika dengan penjelasan medis dan yuridis mendalam.
  - Rotasi bank soal harian otomatis (7 tema puzzle berotasi, lebih dari 100 soal).
  - Sistem reset harian otomatis terjadwal pada pukul 07:00 WITA.
  - Papan peringkat harian (*Daily Leaderboard* Top 10) dan fitur bagikan skor ke aplikasi pesan instan/media sosial.
- **Pusat Informasi FAQ dan Kontak Darurat**:
  - Tanya jawab seputar syarat pendaftaran rehabilitasi sukarela, jaminan kerahasiaan identitas, dan dasar hukum perlindungan saksi/pelapor.
  - Informasi kontak hotline BNNP Sulawesi Tengah, Call Center 184, alamat kantor, serta tautan ke media sosial resmi.
- **Penghitung Pengunjung Unik (Visitor Tracker)**:
  - Pelacakan pengunjung unik harian berbasis kombinasi IP address, session, dan cookie browser (reset otomatis pukul 00:00).
  - Pemfilteran otomatis terhadap bot/crawler mesin pencari.
  - Widget dan modal ringkasan akses (kunjungan hari ini, kemarin, bulan ini, dan total keseluruhan).
- **Tema Tampilan Adaptif**:
  - Dukungan mode terang (*Light Mode*) dan mode gelap (*Dark Mode*) dengan penyimpanan preferensi di `localStorage`.

### 2. Panel Administrasi (Dashboard Admin)

- **Proteksi Akses dan Keamanan**:
  - Halaman login admin terproteksi pada rute khusus `/admin` dengan pembatasan percobaan login (*rate limiting throttle*).
- **Manajemen Zona Kerawanan**:
  - Penambahan, pembaruan, dan penghapusan data wilayah.
  - Pengaturan hierarki kode wilayah dan keterkaitan induk wilayah (*parent code*).
  - Pengisian dan validasi data batas spasial koordinat GeoJSON.
  - Penetapan status zonasi dan jumlah kasus tercatat.
- **Manajemen Artikel dan Media Edukasi**:
  - Pengelolaan konten edukasi (Artikel, Kamus, Media).
  - Pengunggahan gambar sampul dan berkas media pendukung.
  - Relasi kepemilikan artikel terhadap akun staf/penulis.
- **Manajemen Dataset Statistik Kasus**:
  - Pengunggahan berkas CSV untuk import data statistik kasus tahunan secara massal (*bulk import*).
  - Pengelompokan dataset per tahun dan nama dataset.
  - Fitur pembersihan dan penghapusan dataset lama.
- **Manajemen Pengguna dan Kuota Role**:
  - Pembatasan ketat akun Super Admin (dibatasi 1 akun permanen).
  - Pengelolaan staf dengan role Admin operasional (dibatasi maksimal 2 akun).
- **Log Aktivitas Pengguna (Audit Trail)**:
  - Pencatatan aksi krusial pengguna ke dalam basis data (User ID, jenis aksi, deskripsi aktivitas, dan stempel waktu).
- **Pemantauan Riwayat Pengunjung**:
  - Tabel log riwayat akses pengunjung lengkap dengan alamat IP, User Agent, URL tujuan, dan tanggal kunjungan.
  - Fitur pengosongan (*reset*) data log pengunjung bagi Super Admin.
- **Pengaturan Profil Mandiri**:
  - Pembaruan nama pengguna, alamat email, dan penggantian kata sandi mandiri.

---

## Teknologi yang Digunakan

| Komponen | Spesifikasi / Pustaka |
| :--- | :--- |
| **Framework Backend** | Laravel 12.x |
| **Bahasa Pemrograman** | PHP 8.2+ |
| **Database** | MySQL 8.x / MariaDB 10.4+ |
| **Frontend Templating** | Laravel Blade Engine |
| **CSS Framework** | Tailwind CSS v4 (@tailwindcss/vite) |
| **Peta Digital / GIS** | Leaflet.js & Format Standar GeoJSON |
| **Asset Bundler** | Vite 6.x |
| **HTTP Client** | Axios |
| **Manajemen Dependensi** | Composer 2.x & NPM |

---

## Persyaratan Sistem

Sebelum melakukan instalasi di lingkungan lokal atau server produksi, pastikan lingkungan kerja telah memenuhi persyaratan berikut:

- PHP versi 8.2 atau yang lebih baru.
- Ekstensi PHP yang aktif:
  - `pdo_mysql`
  - `mbstring`
  - `openssl`
  - `fileinfo`
  - `curl`
  - `gd`
  - `zip`
  - `xml`
- Composer versi 2.0 atau lebih baru.
- Node.js versi 18.x atau versi LTS terbaru beserta NPM.
- Server basis data MySQL atau MariaDB (misalnya melalui Laragon, XAMPP, atau instalasi native).
- Git CLI.

---

## Panduan Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi pada lingkungan pengembangan lokal:

### 1. Unduh atau Kloning Repositori

Letakkan direktori proyek pada direktori server lokal (misalnya pada direktori root web server seperti `C:\laragon\www\project-bnnp`):

```bash
cd C:\laragon\www\project-bnnp
```

### 2. Pasang Dependensi Backend (Composer)

Jalankan perintah berikut untuk mengunduh semua paket dependensi PHP:

```bash
composer install
```

### 3. Pasang Dependensi Frontend (Node/NPM)

Pasang dependensi pustaka JavaScript dan CSS Tailwind:

```bash
npm install
```

### 4. Konfigurasi Berkas Environment (`.env`)

Salin berkas contoh environment `.env.example` menjadi `.env` jika belum tersedia:

```bash
copy .env.example .env
```

Buka berkas `.env` dan sesuaikan parameter basis data sesuai konfigurasi lokal Anda:

```ini
APP_NAME="SKENA BNNP Sulteng"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bnn
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat Kunci Aplikasi (*Application Key*)

Jalankan perintah artisan untuk membuat `APP_KEY` baru:

```bash
php artisan key:generate
```

### 6. Persiapan Basis Data

Pastikan database dengan nama yang ditentukan (contoh: `bnn`) telah dibuat pada MySQL server Anda:

```sql
CREATE DATABASE bnn CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Terdapat dua opsi untuk mengisi struktur dan data awal:

#### Opsi A: Menggunakan Migrasi dan Seeder (Rekomendasi Bersih)

Menjalankan seluruh migrasi skema tabel serta seeder bawaan (pengguna default, data zona 13 kabupaten/kota se-Sulteng, edukasi sampel, dan bank soal games):

```bash
php artisan migrate:fresh --seed
```

#### Opsi B: Menggunakan Berkas Dump SQL (`bnn.sql`)

Jika ingin menggunakan basis data lengkap yang telah diekspor sebelumnya, impor berkas `bnn.sql` yang tersedia pada direktori root proyek:

```bash
# Melalui terminal MySQL CLI:
mysql -u root -p bnn < bnn.sql

# Atau impor berkas bnn.sql secara langsung melalui antarmuka phpMyAdmin / HeidiSQL.
```

### 7. Buat Symbolic Link Direktori Penyimpanan

Hubungkan direktori publik ke direktori storage agar berkas gambar dan media yang diunggah dapat diakses:

```bash
php artisan storage:link
```

### 8. Jalankan Aplikasi

Jalankan server aplikasi Laravel dan server kompilasi aset Vite pada terminal terpisah:

**Terminal 1 (Server PHP Laravel):**
```bash
php artisan serve
```

**Terminal 2 (Compiler Asset Vite):**
```bash
npm run dev
```

Aplikasi kini dapat diakses melalui peramban web pada alamat:
- **Portal Publik**: `http://localhost:8000` (atau `http://project-bnnp.test` jika menggunakan Laragon virtual host)
- **Panel Admin**: `http://localhost:8000/admin`

---

## Kredensial Pengujian

Setelah proses seeding dijalankan, sistem menyediakan akun pengujian default sebagai berikut:

| Peran (*Role*) | Alamat Email | Kata Sandi | Deskripsi Hak Akses |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@bnn.id` | `12345678` | Akses penuh seluruh modul, manajemen user admin, audit logs, dan reset data pengunjung. |
| **Admin** | `admin@bnn.id` | `12345678` | Akses operasional data zona kerawanan, katalog edukasi, import statistik kasus, dan profil. |

> **Catatan Keamanan**: Untuk penggunaan pada server produksi, segera perbarui alamat email dan kata sandi default tersebut melalui menu Profil Admin atau migrasi data khusus.

---

## Struktur Direktori

Berikut adalah gambaran ringkas struktur direktori utama pada proyek ini:

```
project-bnnp/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                      # Pengontrol operasional panel admin
│   │   │   │   ├── ActivityLogController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── EdukasiController.php
│   │   │   │   ├── PengunjungController.php
│   │   │   │   ├── ProfileController.php
│   │   │   │   ├── StatistikKasusController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── ZonaController.php
│   │   │   ├── AuthController.php          # Otentikasi dan login admin
│   │   │   ├── BerandaController.php       # Halaman beranda utama
│   │   │   ├── EdukasiController.php       # Katalog edukasi publik
│   │   │   ├── FaqKontakController.php     # FAQ & informasi kontak resmi
│   │   │   ├── GameController.php          # Logika Wordle, Mitos/Fakta, Leaderboard
│   │   │   ├── PengunjungController.php    # API statistik pengunjung
│   │   │   ├── PetaController.php          # Peta Leaflet & GeoJSON endpoint
│   │   │   └── StatistikController.php     # Visualisasi statistik publik
│   │   └── Middleware/
│   │       ├── RoleMiddleware.php          # Verifikasi peran pengguna
│   │       └── TrackVisitor.php            # Pencatatan pengunjung unik
│   └── Models/                             # Model Eloquent (Zona, Edukasi, User, dll.)
├── database/
│   ├── migrations/                         # Skema migrasi tabel basis data
│   └── seeders/                            # Seeder akun, zona Sulteng, bank soal
├── public/                                 # Entry point publik (index.php, aset gambar)
│   └── images/                             # Logo resmi BNN dan aset grafis
├── resources/
│   ├── css/                                # Berkas styling Tailwind v4
│   ├── js/                                 # Logika skrip sisi klien
│   └── views/                              # Template Blade
│       ├── admin/                          # Tampilan modul dashboard admin
│       ├── auth/                           # Formulir login admin
│       ├── components/                     # Komponen Blade (modal statistik, widget)
│       ├── layouts/                        # Kerangka layout utama (publik & admin)
│       ├── publik/                         # Halaman portal umum publik
│       └── statistik/                      # Halaman visualisasi statistik data kasus
├── routes/
│   ├── web.php                             # Definisi seluruh rute publik dan admin
│   └── console.php                         # Perintah CLI artisan
├── bnn.sql                                 # Dump cadangan basis data SQL
├── composer.json                           # Konfigurasi dependensi PHP
├── package.json                            # Konfigurasi dependensi Node/Vite
└── vite.config.js                          # Konfigurasi bundler Vite
```

---

## Daftar Rute dan API

### 1. Halaman Publik

| Metode | URL | Nama Rute | Deskripsi |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | `beranda` | Halaman landing page utama |
| `GET` | `/peta` | `peta` | Halaman peta interaktif zona kerawanan GIS |
| `GET` | `/edukasi` | `edukasi.index` | Daftar katalog edukasi dan literasi |
| `GET` | `/edukasi/{id}` | `edukasi.show` | Rincian konten artikel atau edukasi |
| `GET` | `/faq-kontak` | `faq-kontak` | Tanya jawab rehabilitasi dan kontak pengaduan |
| `GET` | `/statistik` | `statistik` | Visualisasi grafik data kasus 3 bidang |
| `GET` | `/game` | `game.index` | Antarmuka mini games Wordle & Mitos/Fakta |

### 2. Endpoint API Publik

| Metode | URL | Nama Rute | Deskripsi |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/peta/geojson` | `peta.geojson` | Data fitur GeoJSON poligon peta wilayah |
| `GET` | `/api/pengunjung/statistik`| `pengunjung.statistik` | Data agregat statistik akses pengunjung |
| `GET` | `/api/game/daily` | `game.daily` | Paket data puzzle Wordle & Mitos/Fakta harian |
| `GET` | `/api/game/random` | `game.random` | Paket soal latihan mini games acak |
| `POST` | `/api/game/record` | `game.record` | Catat riwayat percobaan bermain harian |
| `POST` | `/api/game/reset` | `game.reset` | Reset sesi permainan hari ini |
| `GET` | `/api/game/leaderboard` | `game.leaderboard` | Data 10 peringkat teratas papan skor harian |
| `POST` | `/api/game/leaderboard` | `game.leaderboard.submit` | Pengiriman nama dan perolehan skor pemain |

### 3. Autentikasi dan Panel Admin

| Metode | URL | Middleware | Deskripsi |
| :--- | :--- | :--- | :--- |
| `GET` | `/admin` | `guest` | Formulir login akun administrator |
| `POST` | `/admin` | `throttle:login` | Proses autentikasi masuk |
| `POST` | `/logout` | `auth` | Proses keluar akun |
| `GET` | `/admin/dashboard` | `auth, role:super_admin,admin` | Dashboard statistik operasional admin |
| `RESOURCE`| `/admin/zona` | `auth, role:super_admin,admin` | Manajemen CRUD data zona kerawanan |
| `RESOURCE`| `/admin/edukasi` | `auth, role:super_admin,admin` | Manajemen CRUD artikel dan media edukasi |
| `GET/POST`| `/admin/statistik/*` | `auth, role:super_admin,admin` | Kelola dan impor file CSV statistik kasus |
| `GET` | `/admin/pengunjung` | `auth, role:super_admin,admin` | Pemantauan log riwayat pengunjung |
| `DELETE` | `/admin/pengunjung/reset` | `auth, role:super_admin` | Pengosongan data riwayat pengunjung |
| `RESOURCE`| `/admin/users` | `auth, role:super_admin` | Manajemen akun staf pengguna admin |
| `GET` | `/admin/logs` | `auth, role:super_admin` | Tinjauan audit trail log aktivitas staf |
| `GET/PUT` | `/admin/profile` | `auth` | Tinjau dan perbarui profil serta password |

---

## Hak Akses dan Peran (RBAC)

Aplikasi menerapkan pembatasan hak akses berbasis peran (*Role-Based Access Control*) dengan kebijakan keamanan terstruktur:

### 1. Super Admin
- Memiliki kontrol penuh atas seluruh sistem dan data.
- Mengelola data pengguna admin (menambah dan menghapus akun staf).
- Meninjau log audit seluruh aktivitas sistem (`ActivityLog`).
- Menghapus dan mereset riwayat pencatatan pengunjung.
- Mengelola seluruh data zona, edukasi, dan statistik kasus.
- **Kebijakan Kuota**: Sistem membatasi permanen keberadaan akun Super Admin hanya **1 akun** aktif untuk mencegah fragmentasi otoritas utama.

### 2. Admin
- Mengelola data zonasi kerawanan (menambah, mengubah informasi batas GeoJSON dan status risiko).
- Mengelola materi publikasi edukasi, kamus, dan artikel.
- Mengunggah dan memperbarui dataset statistik kasus melalui berkas CSV.
- Memantau log akses pengunjung situs.
- Mengubah profil dan kata sandi akun miliknya secara mandiri.
- **Kebijakan Kuota**: Akun staf dengan role Admin dibatasi maksimal **2 akun** operasional.

---

## Panduan Import Dataset CSV

Fitur import statistik kasus pada panel admin menerima berkas dengan ekstensi `.csv` atau `.txt` dengan format struktur kolom berikut:

```csv
Kelompok Umur,Jenis Kelamin,Jenis Narkotika,Pekerjaan,Jumlah Kasus
15-19 Tahun,Laki-laki,Sabu (Metamfetamin),Pelajar/Mahasiswa,12
20-24 Tahun,Laki-laki,Sabu (Metamfetamin),Swasta,28
25-29 Tahun,Perempuan,THD / Obat Keras,Wiraswasta,5
```

Aturan validasi:
1. Baris pertama dianggap sebagai tajuk (*header*) kolom dan dilewati pada saat pembacaan data.
2. Kolom 1 sampai 4 berturut-turut merepresentasikan: Kelompok Umur, Jenis Kelamin, Jenis Narkotika, dan Pekerjaan.
3. Kolom ke-5 merepresentasikan nilai numerik jumlah kasus.
4. Jika nama dataset yang diunggah sama dengan dataset yang telah ada pada tahun yang sama, sistem secara otomatis mengganti (*replace*) data lama untuk menjaga integritas agregasi data.

---

## Pemeliharaan dan Troubleshooting

### 1. Gambar Konten Tidak Tampil
Pastikan tautan simbolis folder storage telah dibuat:
```bash
php artisan storage:link
```
Jika tautan rusak, hapus tautan lama di folder `public/storage` lalu jalankan ulang perintah di atas.

### 2. Membersihkan Cache Aplikasi
Jika terdapat perubahan konfigurasi atau template yang tidak termuat dengan benar:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### 3. Izin Akses Folder (*Folder Permissions*)
Pada server Linux/produksi, pastikan web server memiliki hak tulis (*write permission*) pada direktori `storage` dan `bootstrap/cache`:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 4. Kompilasi Aset Produksi
Untuk menerapkan aset CSS dan JavaScript pada lingkungan rilis tanpa perlu menjalankan server Vite:
```bash
npm run build
```

---

## Kontak dan Saluran Resmi

Aplikasi ini dikelola dan diperuntukkan bagi operasional:

- **Instansi**: Badan Narkotika Nasional Provinsi (BNNP) Sulawesi Tengah
- **Alamat**: Jl. Prof. Moh. Yamin No. 27, Kota Palu, Sulawesi Tengah, Indonesia
- **Call Center BNN**: 184
- **Hotline Darurat BNNP Sulteng**: 08114511344
- **Email Resmi**: bnnpsulteng@gmail.com
- **Instagram**: [@bnnpsulteng](https://www.instagram.com/bnnpsulteng)
- **YouTube**: [BNNP Sulawesi Tengah](https://www.youtube.com/@bnnpsulawesitengah)

---

&copy; Badan Narkotika Nasional Provinsi (BNNP) Sulawesi Tengah. Seluruh hak cipta dilindungi undang-undang.
