<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Zona;
use App\Models\Edukasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ──────────────────────────────────────────────
        // Users (1 Super Admin + 3 Admin Bidang)
        // ──────────────────────────────────────────────

        $superAdmin = User::create([
            'name'     => 'Super Admin BNNP',
            'email'    => 'superadmin@bnnp-sulteng.go.id',
            'password' => Hash::make('password'),
            'role'     => 'super_admin',
        ]);

        $adminRehab = User::create([
            'name'     => 'Admin Rehabilitasi',
            'email'    => 'rehab@bnnp-sulteng.go.id',
            'password' => Hash::make('password'),
            'role'     => 'admin_rehab',
        ]);

        $adminBrantas = User::create([
            'name'     => 'Admin Pemberantasan',
            'email'    => 'brantas@bnnp-sulteng.go.id',
            'password' => Hash::make('password'),
            'role'     => 'admin_brantas',
        ]);

        $adminCegah = User::create([
            'name'     => 'Admin Pencegahan',
            'email'    => 'cegah@bnnp-sulteng.go.id',
            'password' => Hash::make('password'),
            'role'     => 'admin_cegah',
        ]);

        // ──────────────────────────────────────────────
        // Zona Kerawanan (Sample data Sulawesi Tengah)
        // ──────────────────────────────────────────────

        Zona::create([
            'nama_wilayah'      => 'Kota Palu',
            'koordinat_geojson' => json_encode([
                'type'        => 'Point',
                'coordinates' => [119.8707, -0.8917],
            ]),
            'status_zona'  => 'merah',
            'jumlah_kasus' => 45,
            'deskripsi'    => 'Zona kerawanan tinggi di ibukota provinsi.',
        ]);

        Zona::create([
            'nama_wilayah'      => 'Kabupaten Donggala',
            'koordinat_geojson' => json_encode([
                'type'        => 'Point',
                'coordinates' => [119.7414, -0.6805],
            ]),
            'status_zona'  => 'kuning',
            'jumlah_kasus' => 18,
            'deskripsi'    => 'Zona kerawanan sedang, area pesisir.',
        ]);

        Zona::create([
            'nama_wilayah'      => 'Kabupaten Sigi',
            'koordinat_geojson' => json_encode([
                'type'        => 'Point',
                'coordinates' => [119.9864, -1.4591],
            ]),
            'status_zona'  => 'kuning',
            'jumlah_kasus' => 12,
            'deskripsi'    => 'Zona kerawanan sedang, area pedalaman.',
        ]);

        Zona::create([
            'nama_wilayah'      => 'Kabupaten Parigi Moutong',
            'koordinat_geojson' => json_encode([
                'type'        => 'Point',
                'coordinates' => [120.1778, -0.3695],
            ]),
            'status_zona'  => 'hijau',
            'jumlah_kasus' => 5,
            'deskripsi'    => 'Zona kerawanan rendah.',
        ]);

        Zona::create([
            'nama_wilayah'      => 'Kabupaten Toli-Toli',
            'koordinat_geojson' => json_encode([
                'type'        => 'Point',
                'coordinates' => [120.7940, 1.0527],
            ]),
            'status_zona'  => 'merah',
            'jumlah_kasus' => 32,
            'deskripsi'    => 'Zona kerawanan tinggi, area perbatasan.',
        ]);

        Zona::create([
            'nama_wilayah'      => 'Kabupaten Banggai',
            'koordinat_geojson' => json_encode([
                'type'        => 'Point',
                'coordinates' => [122.7902, -1.5757],
            ]),
            'status_zona'  => 'kuning',
            'jumlah_kasus' => 15,
            'deskripsi'    => 'Zona kerawanan sedang.',
        ]);

        // ──────────────────────────────────────────────
        // Edukasi (Sample data)
        // ──────────────────────────────────────────────

        Edukasi::create([
            'judul'      => 'Mengenal Bahaya Narkotika Jenis Sabu',
            'kategori'   => 'artikel',
            'konten'     => 'Sabu-sabu atau metamfetamin adalah narkotika golongan I yang memiliki efek stimulan kuat pada sistem saraf pusat. Penggunaan sabu dapat menyebabkan kerusakan otak permanen, gangguan jantung, dan kematian. BNNP Sulawesi Tengah terus melakukan sosialisasi tentang bahaya narkotika jenis ini kepada masyarakat, khususnya generasi muda.',
            'penulis_id' => $adminCegah->id,
        ]);

        Edukasi::create([
            'judul'      => 'Program Rehabilitasi BNNP Sulawesi Tengah',
            'kategori'   => 'artikel',
            'konten'     => 'BNNP Sulawesi Tengah menyediakan layanan rehabilitasi bagi korban penyalahgunaan narkotika. Program ini meliputi rehabilitasi medis dan sosial yang bertujuan memulihkan kondisi fisik dan mental para korban. Layanan ini bersifat gratis dan rahasia.',
            'penulis_id' => $adminRehab->id,
        ]);

        Edukasi::create([
            'judul'      => 'Glosarium: Istilah-Istilah Narkotika',
            'kategori'   => 'kamus',
            'konten'     => 'Berikut adalah kumpulan istilah yang sering digunakan dalam konteks narkotika dan penyalahgunaannya: Narkotika, Psikotropika, Zat Adiktif, Rehabilitasi Medis, Rehabilitasi Sosial, Pecandu, Penyalah Guna, Pengedar, Bandar, Kurir, Prekursor.',
            'penulis_id' => $superAdmin->id,
        ]);

        Edukasi::create([
            'judul'      => 'Infografis: Dampak Narkotika pada Otak',
            'kategori'   => 'media',
            'konten'     => 'Infografis ini menjelaskan secara visual bagaimana narkotika mempengaruhi fungsi otak manusia, mulai dari gangguan neurotransmitter hingga kerusakan sel-sel otak yang bersifat permanen.',
            'file_path'  => 'edukasi/infografis-dampak-narkotika.jpg',
            'penulis_id' => $adminCegah->id,
        ]);
    }
}
