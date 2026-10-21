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
        // Users (1 Super Admin + 1 Akun Admin Tunggal)
        // ──────────────────────────────────────────────

        $superAdmin = User::create([
            'name'     => 'Super Admin BNNP',
            'email'    => 'superadmin@bnn.id',
            'password' => Hash::make('12345678'),
            'role'     => 'super_admin',
        ]);

        $admin = User::create([
            'name'     => 'Admin BNNP',
            'email'    => 'admin@bnn.id',
            'password' => Hash::make('12345678'),
            'role'     => 'admin',
        ]);

        // ──────────────────────────────────────────────
        // Zona Kerawanan (Seluruh 13 Kabupaten/Kota se-Sulawesi Tengah Poligon Resmi)
        // ──────────────────────────────────────────────

        $this->call(ZonaSultengSeeder::class);

        // ──────────────────────────────────────────────
        // Edukasi (Sample data)
        // ──────────────────────────────────────────────

        Edukasi::create([
            'judul'      => 'Mengenal Bahaya Narkotika Jenis Sabu',
            'kategori'   => 'artikel',
            'konten'     => 'Sabu-sabu atau metamfetamin adalah narkotika golongan I yang memiliki efek stimulan kuat pada sistem saraf pusat. Penggunaan sabu dapat menyebabkan kerusakan otak permanen, gangguan jantung, dan kematian. BNNP Sulawesi Tengah terus melakukan sosialisasi tentang bahaya narkotika jenis ini kepada masyarakat, khususnya generasi muda.',
            'gambar'     => 'edukasi/gambar/bahaya-sabu.jpg',
            'penulis_id' => $admin->id,
        ]);

        Edukasi::create([
            'judul'      => 'Program Rehabilitasi BNNP Sulawesi Tengah',
            'kategori'   => 'artikel',
            'konten'     => 'BNNP Sulawesi Tengah menyediakan layanan rehabilitasi bagi korban penyalahgunaan narkotika. Program ini meliputi rehabilitasi medis dan sosial yang bertujuan memulihkan kondisi fisik dan mental para korban. Layanan ini bersifat gratis dan rahasia.',
            'gambar'     => 'edukasi/gambar/rehabilitasi-bnnp.jpg',
            'penulis_id' => $admin->id,
        ]);

        Edukasi::create([
            'judul'      => 'Glosarium: Istilah-Istilah Narkotika',
            'kategori'   => 'kamus',
            'konten'     => 'Berikut adalah kumpulan istilah yang sering digunakan dalam konteks narkotika dan penyalahgunaannya: Narkotika, Psikotropika, Zat Adiktif, Rehabilitasi Medis, Rehabilitasi Sosial, Pecandu, Penyalah Guna, Pengedar, Bandar, Kurir, Prekursor.',
            'gambar'     => 'edukasi/gambar/kamus-istilah.jpg',
            'penulis_id' => $superAdmin->id,
        ]);

        Edukasi::create([
            'judul'      => 'Infografis: Dampak Narkotika pada Otak',
            'kategori'   => 'media',
            'konten'     => 'Infografis ini menjelaskan secara visual bagaimana narkotika mempengaruhi fungsi otak manusia, mulai dari gangguan neurotransmitter hingga kerusakan sel-sel otak yang bersifat permanen.',
            'gambar'     => 'edukasi/gambar/infografis-otak.jpg',
            'file_path'  => 'edukasi/gambar/infografis-otak.jpg',
            'penulis_id' => $admin->id,
        ]);

        // ──────────────────────────────────────────────
        // Bank Soal Game Edukasi (100 Wordle & 100 Mitos/Fakta)
        // ──────────────────────────────────────────────
        $this->call([
            GameWordleSeeder::class,
            GameMitosFaktaSeeder::class,
        ]);
    }
}
