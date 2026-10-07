<?php

namespace Database\Seeders;

use App\Models\Zona;
use Illuminate\Database\Seeder;

class ZonaSultengSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('data/sulawesi_tengah_kabupaten.geojson');

        if (!file_exists($filePath)) {
            $this->command?->error("File GeoJSON tidak ditemukan: {$filePath}");
            return;
        }

        $geoJson = json_decode(file_get_contents($filePath), true);

        if (!$geoJson || !isset($geoJson['features'])) {
            $this->command?->error("Format GeoJSON tidak valid.");
            return;
        }

        // Pemetaan nama wilayah agar rapi sesuai format resmi
        $nameMap = [
            'KAB. BANGGAI'           => 'Kabupaten Banggai',
            'KAB. POSO'              => 'Kabupaten Poso',
            'KAB. DONGGALA'          => 'Kabupaten Donggala',
            'KAB. TOLI TOLI'         => 'Kabupaten Tolitoli',
            'KAB. BUOL'              => 'Kabupaten Buol',
            'KAB. MOROWALI'          => 'Kabupaten Morowali',
            'KAB. BANGGAI KEPULAUAN' => 'Kabupaten Banggai Kepulauan',
            'KAB. PARIGI MOUTONG'    => 'Kabupaten Parigi Moutong',
            'KAB. TOJO UNA UNA'      => 'Kabupaten Tojo Una-Una',
            'KAB. SIGI'              => 'Kabupaten Sigi',
            'KAB. BANGGAI LAUT'      => 'Kabupaten Banggai Laut',
            'KAB. MOROWALI UTARA'    => 'Kabupaten Morowali Utara',
            'KOTA PALU'              => 'Kota Palu',
        ];

        // Sample status & jumlah kasus awal
        $defaultConfig = [
            'Kota Palu'                  => ['status' => 'merah',  'kasus' => 54, 'deskripsi' => 'Pusat ibukota provinsi, tingkat mobilitas dan potensi peredaran tinggi.'],
            'Kabupaten Donggala'         => ['status' => 'kuning', 'kasus' => 22, 'deskripsi' => 'Wilayah pesisir dan jalur transportasi laut.'],
            'Kabupaten Sigi'             => ['status' => 'kuning', 'kasus' => 16, 'deskripsi' => 'Daerah penyangga ibukota provinsi.'],
            'Kabupaten Parigi Moutong'   => ['status' => 'hijau',  'kasus' => 8,  'deskripsi' => 'Pengawasan intensif di jalur lintas timur.'],
            'Kabupaten Tolitoli'         => ['status' => 'merah',  'kasus' => 35, 'deskripsi' => 'Jalur perbatasan maritim utara.'],
            'Kabupaten Buol'             => ['status' => 'hijau',  'kasus' => 6,  'deskripsi' => 'Tingkat kerawanan terpantau rendah dan terkendali.'],
            'Kabupaten Poso'             => ['status' => 'kuning', 'kasus' => 19, 'deskripsi' => 'Titik pertemuan jalur trans-Sulawesi.'],
            'Kabupaten Tojo Una-Una'     => ['status' => 'hijau',  'kasus' => 4,  'deskripsi' => 'Wilayah kepulauan dan destinasi wisata.'],
            'Kabupaten Banggai'          => ['status' => 'kuning', 'kasus' => 24, 'deskripsi' => 'Pusat ekonomi timur Sulawesi Tengah.'],
            'Kabupaten Banggai Kepulauan'=> ['status' => 'hijau',  'kasus' => 5,  'deskripsi' => 'Wilayah kepulauan dengan risiko rendah.'],
            'Kabupaten Banggai Laut'     => ['status' => 'hijau',  'kasus' => 3,  'deskripsi' => 'Zona kerawanan rendah.'],
            'Kabupaten Morowali'         => ['status' => 'merah',  'kasus' => 41, 'deskripsi' => 'Kawasan industri pertambangan dengan pertumbuhan populasi dan pekerja tinggi.'],
            'Kabupaten Morowali Utara'   => ['status' => 'kuning', 'kasus' => 18, 'deskripsi' => 'Kawasan perkembangan industri dan logistik.'],
        ];

        foreach ($geoJson['features'] as $feature) {
            $rawName = $feature['properties']['name'] ?? '';
            $namaWilayah = $nameMap[$rawName] ?? ucwords(strtolower($rawName));
            $config = $defaultConfig[$namaWilayah] ?? ['status' => 'hijau', 'kasus' => 0, 'deskripsi' => 'Wilayah Sulawesi Tengah.'];

            // Simpan bentuk polygon utuh ke koordinat_geojson
            $geometryJson = json_encode($feature['geometry']);

            // Update jika sudah ada (berdasarkan kemiripan nama) atau buat baru
            $existing = Zona::where('nama_wilayah', 'LIKE', "%{$namaWilayah}%")
                ->orWhere('nama_wilayah', 'LIKE', "%" . str_replace(['Kabupaten ', 'Kota '], '', $namaWilayah) . "%")
                ->first();

            if ($existing) {
                $existing->update([
                    'nama_wilayah'      => $namaWilayah,
                    'koordinat_geojson' => $geometryJson,
                    'status_zona'       => $config['status'],
                    'jumlah_kasus'      => $config['kasus'],
                    'deskripsi'         => $config['deskripsi'],
                ]);
            } else {
                Zona::create([
                    'nama_wilayah'      => $namaWilayah,
                    'koordinat_geojson' => $geometryJson,
                    'status_zona'       => $config['status'],
                    'jumlah_kasus'      => $config['kasus'],
                    'deskripsi'         => $config['deskripsi'],
                ]);
            }
        }

        // Hapus dummy data lama yang tidak valid jika ada
        Zona::whereNotIn('nama_wilayah', array_values($nameMap))->delete();
    }
}
