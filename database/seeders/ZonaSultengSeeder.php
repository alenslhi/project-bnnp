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
        $baseDir = database_path('data/geojson');
        $kabFile = database_path('data/sulawesi_tengah_kabupaten.geojson');

        if (!file_exists($kabFile)) {
            $this->command?->error("File GeoJSON Kabupaten tidak ditemukan: {$kabFile}");
            return;
        }

        $kabGeoJson = json_decode(file_get_contents($kabFile), true);

        // ══════════════════════════════════════════════════════════════
        // 1. TINGKAT KABUPATEN / KOTA (13 Wilayah se-Sulawesi Tengah)
        // ══════════════════════════════════════════════════════════════
        $nameMap = [
            'KAB. BANGGAI'           => ['name' => 'Kabupaten Banggai',           'code' => '72.01'],
            'KAB. POSO'              => ['name' => 'Kabupaten Poso',              'code' => '72.02'],
            'KAB. DONGGALA'          => ['name' => 'Kabupaten Donggala',          'code' => '72.03'],
            'KAB. TOLI TOLI'         => ['name' => 'Kabupaten Tolitoli',           'code' => '72.04'],
            'KAB. BUOL'              => ['name' => 'Kabupaten Buol',              'code' => '72.05'],
            'KAB. MOROWALI'          => ['name' => 'Kabupaten Morowali',          'code' => '72.06'],
            'KAB. BANGGAI KEPULAUAN' => ['name' => 'Kabupaten Banggai Kepulauan', 'code' => '72.07'],
            'KAB. PARIGI MOUTONG'    => ['name' => 'Kabupaten Parigi Moutong',    'code' => '72.08'],
            'KAB. TOJO UNA UNA'      => ['name' => 'Kabupaten Tojo Una-Una',      'code' => '72.09'],
            'KAB. SIGI'              => ['name' => 'Kabupaten Sigi',              'code' => '72.10'],
            'KAB. BANGGAI LAUT'      => ['name' => 'Kabupaten Banggai Laut',      'code' => '72.11'],
            'KAB. MOROWALI UTARA'    => ['name' => 'Kabupaten Morowali Utara',    'code' => '72.12'],
            'KOTA PALU'              => ['name' => 'Kota Palu',                   'code' => '72.71'],
        ];

        $defaultKabConfig = [
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

        $kabupatenCodeToName = [];

        foreach ($kabGeoJson['features'] as $feature) {
            $rawName = $feature['properties']['name'] ?? '';
            $info = $nameMap[$rawName] ?? ['name' => ucwords(strtolower($rawName)), 'code' => $feature['properties']['code'] ?? '72.00'];
            $namaWilayah = $info['name'];
            $kodeWilayah = $info['code'];
            $kabupatenCodeToName[$kodeWilayah] = $namaWilayah;
            $normalizedCode = str_replace('.', '_', $kodeWilayah);
            $kabupatenCodeToName[$normalizedCode] = $namaWilayah;

            $config = $defaultKabConfig[$namaWilayah] ?? ['status' => 'hijau', 'kasus' => 0, 'deskripsi' => 'Wilayah Sulawesi Tengah.'];

            Zona::updateOrCreate(
                ['kode_wilayah' => $kodeWilayah, 'tingkat' => 'kabupaten'],
                [
                    'nama_wilayah'      => $namaWilayah,
                    'tingkat'           => 'kabupaten',
                    'kode_wilayah'      => $kodeWilayah,
                    'parent_kode'       => null,
                    'parent_nama'       => null,
                    'koordinat_geojson' => json_encode($feature['geometry']),
                    'status_zona'       => $config['status'],
                    'jumlah_kasus'      => $config['kasus'],
                    'deskripsi'         => $config['deskripsi'],
                ]
            );
        }

        // ══════════════════════════════════════════════════════════════
        // 2. TINGKAT KECAMATAN (167 Kecamatan se-Sulawesi Tengah)
        // ══════════════════════════════════════════════════════════════
        $districtFiles = glob("{$baseDir}/districts_*.geojson");
        $kecamatanCodeToName = [];

        foreach ($districtFiles as $file) {
            $data = json_decode(file_get_contents($file), true);
            if (!isset($data['features'])) continue;

            // Ambil kode kabupaten dari nama file, misal districts_72_71.geojson -> 72.71
            preg_match('/districts_(\d+)_(\d+)\.geojson/', basename($file), $matches);
            $parentKode = isset($matches[1], $matches[2]) ? "{$matches[1]}.{$matches[2]}" : null;
            $parentNama = $parentKode && isset($kabupatenCodeToName[$parentKode]) ? $kabupatenCodeToName[$parentKode] : 'Sulawesi Tengah';

            foreach ($data['features'] as $f) {
                $rawName = $f['properties']['name'] ?? '';
                $namaKecamatan = ucwords(strtolower($rawName));
                if (!str_starts_with($namaKecamatan, 'Kecamatan ') && !str_starts_with($namaKecamatan, 'Kec. ')) {
                    $namaKecamatan = 'Kecamatan ' . str_replace('Kec. ', '', $namaKecamatan);
                }
                $kodeKecamatan = $f['properties']['code'] ?? '';
                $kecamatanCodeToName[$kodeKecamatan] = $namaKecamatan;
                $kecamatanCodeToName[str_replace('.', '_', $kodeKecamatan)] = $namaKecamatan;

                // Status awal variatif
                $status = 'hijau';
                $kasus = rand(1, 12);
                if (stripos($namaKecamatan, 'Tawaeli') !== false || stripos($namaKecamatan, 'Palu Timur') !== false || stripos($namaKecamatan, 'Palu Selatan') !== false) {
                    $status = 'kuning';
                    $kasus = rand(15, 25);
                } elseif (stripos($namaKecamatan, 'Palu Barat') !== false || stripos($namaKecamatan, 'Bahodopi') !== false) {
                    $status = 'merah';
                    $kasus = rand(25, 38);
                }

                Zona::updateOrCreate(
                    ['kode_wilayah' => $kodeKecamatan, 'tingkat' => 'kecamatan'],
                    [
                        'nama_wilayah'      => $namaKecamatan,
                        'tingkat'           => 'kecamatan',
                        'kode_wilayah'      => $kodeKecamatan,
                        'parent_kode'       => $parentKode,
                        'parent_nama'       => $parentNama,
                        'koordinat_geojson' => json_encode($f['geometry']),
                        'status_zona'       => $status,
                        'jumlah_kasus'      => $kasus,
                        'deskripsi'         => "Wilayah {$namaKecamatan}, {$parentNama}.",
                    ]
                );
            }
        }

        // ══════════════════════════════════════════════════════════════
        // 3. TINGKAT KELURAHAN / DESA (Kota Palu & Sekitarnya)
        // ══════════════════════════════════════════════════════════════
        $kelurahanFiles = glob("{$baseDir}/kelurahan_*.geojson");

        // Custom config desa/kelurahan penting
        $kelurahanCustomConfig = [
            'Kayumalue Ngapa'  => ['status' => 'merah',  'kasus' => 14, 'deskripsi' => 'Area pemantauan rawan peredaran di Palu Utara.'],
            'Kayumalue Pajeko' => ['status' => 'kuning', 'kasus' => 8,  'deskripsi' => 'Area waspada pesisir Palu Utara.'],
            'Baiya'            => ['status' => 'kuning', 'kasus' => 9,  'deskripsi' => 'Area pelabuhan/pesisir Tawaeli.'],
            'Pantoloan'        => ['status' => 'merah',  'kasus' => 17, 'deskripsi' => 'Kawasan pelabuhan peti kemas & industri Tawaeli.'],
            'Taipa'            => ['status' => 'kuning', 'kasus' => 7,  'deskripsi' => 'Area wisata dan pesisir Palu Utara.'],
            'Mamboro'          => ['status' => 'kuning', 'kasus' => 10, 'deskripsi' => 'Jalur perlintasan Palu Utara.'],
            'Besusu Barat'     => ['status' => 'merah',  'kasus' => 18, 'deskripsi' => 'Pusat keramaian kota.'],
            'Lere'             => ['status' => 'kuning', 'kasus' => 11, 'deskripsi' => 'Kawasan pesisir Teluk Palu.'],
        ];

        foreach ($kelurahanFiles as $file) {
            $data = json_decode(file_get_contents($file), true);
            if (!isset($data['features'])) continue;

            // Ambil kode kecamatan dari nama file: kelurahan_72_71_04.geojson -> 72.71.04
            preg_match('/kelurahan_(\d+)_(\d+)_(\d+)\.geojson/', basename($file), $matches);
            $parentKode = isset($matches[1], $matches[2], $matches[3]) ? "{$matches[1]}.{$matches[2]}.{$matches[3]}" : '72.71';
            $parentNama = isset($kecamatanCodeToName[$parentKode]) ? $kecamatanCodeToName[$parentKode] : 'Kota Palu';

            foreach ($data['features'] as $f) {
                $rawName = $f['properties']['name'] ?? '';
                $cleanName = trim(preg_replace('/\s+/', ' ', str_replace(['KEL.', 'DESA'], '', $rawName)));
                $namaDesa = (str_starts_with($rawName, 'DESA') ? 'Desa ' : 'Kelurahan ') . ucwords(strtolower($cleanName));
                $kodeDesa = $f['properties']['code'] ?? '';

                $status = 'hijau';
                $kasus = rand(1, 6);
                $deskripsi = "Wilayah {$namaDesa}, {$parentNama}.";

                foreach ($kelurahanCustomConfig as $key => $cfg) {
                    if (stripos($cleanName, $key) !== false) {
                        $status = $cfg['status'];
                        $kasus = $cfg['kasus'];
                        $deskripsi = $cfg['deskripsi'];
                        break;
                    }
                }

                Zona::updateOrCreate(
                    ['kode_wilayah' => $kodeDesa, 'tingkat' => 'kelurahan'],
                    [
                        'nama_wilayah'      => $namaDesa,
                        'tingkat'           => 'kelurahan',
                        'kode_wilayah'      => $kodeDesa,
                        'parent_kode'       => $parentKode,
                        'parent_nama'       => $parentNama,
                        'koordinat_geojson' => json_encode($f['geometry']),
                        'status_zona'       => $status,
                        'jumlah_kasus'      => $kasus,
                        'deskripsi'         => $deskripsi,
                    ]
                );
            }
        }
    }
}
