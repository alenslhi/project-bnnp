<?php

namespace Database\Seeders;

use App\Models\GameWordle;
use Illuminate\Database\Seeder;

class GameWordleSeeder extends Seeder
{
    public function run(): void
    {
        GameWordle::truncate();

        $words = [
            // Pasangan 1: Narkotika Populer
            [
                'word' => 'SABU',
                'hint' => 'Narkotika jenis kristal putih yang dihisap dengan alat bong (4 huruf).',
                'category' => 'Jenis Narkotika',
                'definition' => 'SABU: Metamfetamin kristal yang merusak saraf otak dan memicu paranoia.',
            ],
            [
                'word' => 'GANJA',
                'hint' => 'Tanaman terlarang dengan daun hijau menjari yang sering dilinting (5 huruf).',
                'category' => 'Jenis Narkotika',
                'definition' => 'GANJA: Tanaman terlarang Cannabis sativa golongan I menurut UU Narkotika.',
            ],

            // Pasangan 2: Ketergantungan & Pemulihan
            [
                'word' => 'CANDU',
                'hint' => 'Rasa ketagihan yang bikin pengen pakai narkoba terus-menerus (5 huruf).',
                'category' => 'Adiksi',
                'definition' => 'CANDU: Keterikatan fisik dan psikologis akut akibat zat adiktif.',
            ],
            [
                'word' => 'REHAB',
                'hint' => 'Tempat perawatan dan pemulihan bagi orang kecanduan narkoba (5 huruf).',
                'category' => 'Pemulihan',
                'definition' => 'REHAB: Layanan pemulihan medis dan sosial terpadu dari BNN agar pecandu pulih.',
            ],

            // Pasangan 3: Racun & Hidup Sehat
            [
                'word' => 'RACUN',
                'hint' => 'Zat berbahaya yang mematikan dan merusak organ tubuh manusia (5 huruf).',
                'category' => 'Bahaya Fisik',
                'definition' => 'RACUN: Zat kimia destruktif di dalam narkoba perusak organ vital tubuh.',
            ],
            [
                'word' => 'SEHAT',
                'hint' => 'Kondisi tubuh bugar dan tidak sakit, lawan kata dari sakit (5 huruf).',
                'category' => 'Gaya Hidup',
                'definition' => 'SEHAT: Keadaan bugar dan seimbang raga serta jiwa tanpa narkotika.',
            ],

            // Pasangan 4: Kesembuhan & Kebebasan
            [
                'word' => 'PULIH',
                'hint' => 'Keadaan sembuh kembali seperti semula setelah diobati (5 huruf).',
                'category' => 'Pemulihan',
                'definition' => 'PULIH: Kondisi sembuh dari ketergantungan dan siap kembali berprestasi.',
            ],
            [
                'word' => 'BEBAS',
                'hint' => 'Kondisi merdeka dan terlepas dari jeratan narkoba (5 huruf).',
                'category' => 'Masa Depan',
                'definition' => 'BEBAS: Hidup merdeka tanpa kecanduan zat berbahaya untuk masa depan gemilang.',
            ],

            // Pasangan 5: Jarum & Kesehatan Jiwa
            [
                'word' => 'JARUM',
                'hint' => 'Benda tajam runcing pada alat suntik narkoba yang rawan tular virus (5 huruf).',
                'category' => 'Alat Berbahaya',
                'definition' => 'JARUM: Media penularan virus berbahaya seperti HIV bila digunakan bergantian.',
            ],
            [
                'word' => 'WARAS',
                'hint' => 'Pikiran sehat dan berakal budi, lawan kata dari gila atau hilang akal (5 huruf).',
                'category' => 'Kesehatan Jiwa',
                'definition' => 'WARAS: Kondisi akal budi sehat dan mampu berpikir rasional tanpa zat adiktif.',
            ],

            // Pasangan 6: Kesadaran & Hukum
            [
                'word' => 'SADAR',
                'hint' => 'Kondisi pikiran jernih, lawan kata dari pingsan atau teler (5 huruf).',
                'category' => 'Sikap Diri',
                'definition' => 'SADAR: Keadaan terjaga dan memahami bahaya narkotika bagi diri dan keluarga.',
            ],
            [
                'word' => 'HUKUM',
                'hint' => 'Peraturan resmi negara yang memberi sanksi pidana bagi pengedar narkoba (5 huruf).',
                'category' => 'Regulasi',
                'definition' => 'HUKUM: Ketetapan perundang-undangan pidana yang menindak kejahatan narkotika.',
            ],

            // Pasangan 7: Aparat & Bahaya
            [
                'word' => 'POLISI',
                'hint' => 'Aparat penegak hukum berseragam yang menangkap bandar narkoba (6 huruf).',
                'category' => 'Penegakan Hukum',
                'definition' => 'POLISI: Penegak hukum yang menangkap sindikat dan bandar narkoba bersama BNN.',
            ],
            [
                'word' => 'BAHAYA',
                'hint' => 'Kondisi tidak aman dan berisiko mencelakakan tubuh manusia (6 huruf).',
                'category' => 'Edukasi Risiko',
                'definition' => 'BAHAYA: Segala ancaman kerusakan fisik dan mental akibat obat terlarang.',
            ],

            // Pasangan 8: Tubuh & Titik Awal
            [
                'word' => 'DARAH',
                'hint' => 'Cairan berwarna merah yang mengalir di dalam tubuh manusia (5 huruf).',
                'category' => 'Organ Tubuh',
                'definition' => 'DARAH: Cairan pengalir oksigen yang menyerap racun obat terlarang ke organ tubuh.',
            ],
            [
                'word' => 'ROKOK',
                'hint' => 'Batang tembakau hisap berpuntung yang merusak paru-paru (5 huruf).',
                'category' => 'Pintu Masuk',
                'definition' => 'ROKOK: Zat adiktif nikotin yang kerap menjadi gerbang awal mencoba narkoba.',
            ],

            // Pasangan 9: Organ Otak & Tes Medis
            [
                'word' => 'OTAK',
                'hint' => 'Organ vital di dalam kepala yang digunakan untuk berpikir (4 huruf).',
                'category' => 'Organ Vital',
                'definition' => 'OTAK: Pusat kendali tubuh dan memori yang sel sarafnya dirusak narkoba.',
            ],
            [
                'word' => 'URIN',
                'hint' => 'Air kencing yang digunakan sebagai sampel pemeriksaan tes narkoba (4 huruf).',
                'category' => 'Pemeriksaan Medis',
                'definition' => 'URIN: Sampel biologis untuk menguji keberadaan zat narkotika dalam tubuh.',
            ],

            // Pasangan 10: Obat & Dampak Kerusakan
            [
                'word' => 'OBAT',
                'hint' => 'Bahan sediaan pil atau kapsul untuk menyembuhkan orang sakit (4 huruf).',
                'category' => 'Farmakologi',
                'definition' => 'OBAT: Sediaan kimia medis yang bila disalahgunakan dapat memicu kecanduan.',
            ],
            [
                'word' => 'RUSAK',
                'hint' => 'Kondisi organ tubuh yang hancur karena pengaruh zat berbahaya (5 huruf).',
                'category' => 'Dampak Narkoba',
                'definition' => 'RUSAK: Kehancuran sel tubuh dan hilangnya masa depan akibat narkoba.',
            ],

            // Pasangan 11: Ketegasan & Beban Pikiran
            [
                'word' => 'TEGAS',
                'hint' => 'Sikap berani menolak ajakan memakai narkoba tanpa ragu-ragu (5 huruf).',
                'category' => 'Karakter Diri',
                'definition' => 'TEGAS: Sikap berani menolak bujukan negatif demi menjaga masa depan.',
            ],
            [
                'word' => 'STRES',
                'hint' => 'Beban pikiran atau tekanan mental yang berat (5 huruf).',
                'category' => 'Kesehatan Jiwa',
                'definition' => 'STRES: Tekanan emosional yang harus diatasi dengan kegiatan positif, bukan obat.',
            ],

            // Pasangan 12: Bahan Buatan & Lingkungan Aman
            [
                'word' => 'KIMIA',
                'hint' => 'Bahan sintetis buatan pabrik yang dicampur dalam narkoba terlarang (5 huruf).',
                'category' => 'Zat Berbahaya',
                'definition' => 'KIMIA: Campuran zat kimia industri ilegal yang merusak sistem saraf.',
            ],
            [
                'word' => 'AMAN',
                'hint' => 'Kondisi tenteram, damai, dan bebas dari ancaman bahaya (4 huruf).',
                'category' => 'Lingkungan',
                'definition' => 'AMAN: Kondisi pemukiman yang terlindung dari ancaman sindikat narkoba.',
            ],

            // Pasangan 13: Kehidupan & Ketahanan Diri
            [
                'word' => 'HIDUP',
                'hint' => 'Bernapas dan beraktivitas di dunia, lawan kata dari mati (5 huruf).',
                'category' => 'Nilai Kehidupan',
                'definition' => 'HIDUP: Anugerah kehidupan yang bermakna bila dijalani sehat tanpa narkoba.',
            ],
            [
                'word' => 'KUAT',
                'hint' => 'Bertenaga dan tangguh menolak godaan, lawan kata dari lemah (4 huruf).',
                'category' => 'Ketahanan Diri',
                'definition' => 'KUAT: Ketangguhan mental seorang pemuda dalam menolak ajakan buruk.',
            ],

            // Pasangan 14: Bahaya Ekstrem & Hilang Kesadaran
            [
                'word' => 'MAUT',
                'hint' => 'Kematian atau akhir hayat yang mengintai akibat overdosis narkoba (4 huruf).',
                'category' => 'Risiko Fatal',
                'definition' => 'MAUT: Kematian mendadak akibat kegagalan jantung karena overdosis.',
            ],
            [
                'word' => 'KOMA',
                'hint' => 'Keadaan pingsan dan tidak sadarkan diri lama di rumah sakit (4 huruf).',
                'category' => 'Dampak Medis',
                'definition' => 'KOMA: Kondisi penurunan kesadaran stadium akhir akibat keracunan zat.',
            ],

            // Pasangan 15: Pergaulan & Sakaw
            [
                'word' => 'TEMAN',
                'hint' => 'Sahabat atau kawan sepermainan dalam pergaulan sehari-hari (5 huruf).',
                'category' => 'Lingkungan Sosial',
                'definition' => 'TEMAN: Sahabat sebaya yang membawa pengaruh positif dalam pergaulan.',
            ],
            [
                'word' => 'SAKAW',
                'hint' => 'Rasa sakit menyiksa saat tubuh pecandu mendadak putus zat narkoba (5 huruf).',
                'category' => 'Gejala Putus Zat',
                'definition' => 'SAKAW: Reaksi fisik menyiksa saat tubuh tidak mendapat pasokan zat harian.',
            ],

            // Pasangan 16: Nyeri Otot & Takaran Obat
            [
                'word' => 'KRAM',
                'hint' => 'Kejang kaku dan nyeri hebat pada otot tubuh saat sakaw (4 huruf).',
                'category' => 'Gejala Fisik',
                'definition' => 'KRAM: Kontraksi otot menyakitkan yang timbul saat pecandu putus zat.',
            ],
            [
                'word' => 'DOSIS',
                'hint' => 'Ukuran atau takaran pemakaian obat yang dikonsumsi (5 huruf).',
                'category' => 'Takaran Obat',
                'definition' => 'DOSIS: Jumlah takaran zat yang melewati batas aman hingga merusak tubuh.',
            ],

            // Pasangan 17: Budi Pekerti & Lokasi Balai BNN
            [
                'word' => 'MORAL',
                'hint' => 'Budi pekerti dan akhlak terpuji agar tidak terjerumus hal buruk (5 huruf).',
                'category' => 'Nilai Etika',
                'definition' => 'MORAL: Budi pekerti luhur pembimbing perbuatan baik dalam kehidupan.',
            ],
            [
                'word' => 'BOGOR',
                'hint' => 'Kota di Jawa Barat lokasi pusat balai rehabilitasi BNN Lido (5 huruf).',
                'category' => 'Pusat Pemulihan',
                'definition' => 'BOGOR: Lokasi Balai Besar Rehabilitasi BNN Lido yang membantu pecandu pulih.',
            ],

            // Pasangan 18: Kondisi Buruk & Hidup Alami
            [
                'word' => 'PARAH',
                'hint' => 'Tingkat sakit atau kecanduan yang sudah stadium sangat berat (5 huruf).',
                'category' => 'Kondisi Medis',
                'definition' => 'PARAH: Tingkat ketergantungan kronis yang membutuhkan perawatan medis.',
            ],
            [
                'word' => 'ALAMI',
                'hint' => 'Berasal murni dari alam tanpa campuran bahan kimia buatan (5 huruf).',
                'category' => 'Pola Hidup',
                'definition' => 'ALAMI: Pola hidup murni dengan makanan sehat dan olahraga tanpa obat terlarang.',
            ],

            // Pasangan 19: Sikap Pencegahan & Penolakan
            [
                'word' => 'CEGAH',
                'hint' => 'Tindakan membentengi diri sebelum terlanjur terjadi hal buruk (5 huruf).',
                'category' => 'Pencegahan',
                'definition' => 'CEGAH: Upaya preventif menjauhkan generasi muda dari ancaman narkoba.',
            ],
            [
                'word' => 'TOLAK',
                'hint' => 'Menyatakan tidak mau menerima ajakan narkoba, lawan dari terima (5 huruf).',
                'category' => 'Aksi Penolakan',
                'definition' => 'TOLAK: Sikap tegas tidak kompromi terhadap tawaran zat terlarang.',
            ],

            // Pasangan 20: Menghindar & Kepedulian
            [
                'word' => 'HINDAR',
                'hint' => 'Menjauhkan diri dari pergaulan bebas dan tempat-tempat berbahaya (6 huruf).',
                'category' => 'Tindakan Waspada',
                'definition' => 'HINDAR: Tindakan menjauhkan diri dari lingkungan rawan peredaran narkoba.',
            ],
            [
                'word' => 'PEDULI',
                'hint' => 'Sikap empati dan perhatian tulus menolong sesama yang kesusahan (6 huruf).',
                'category' => 'Empati Sosial',
                'definition' => 'PEDULI: Sikap tanggap dan peduli menolong sesama agar terbebas dari narkotika.',
            ],

            // Pasangan 21: Menjauh & Merawat
            [
                'word' => 'JAUHI',
                'hint' => 'Perintah untuk tidak mendekati narkoba dan barang haram (5 huruf).',
                'category' => 'Pencegahan',
                'definition' => 'JAUHI: Komitmen teguh menjaga jarak dari barang haram dan peredarannya.',
            ],
            [
                'word' => 'RAWAT',
                'hint' => 'Menjaga dan mengobati orang sakit agar bisa lekas sembuh (5 huruf).',
                'category' => 'Layanan Medis',
                'definition' => 'RAWAT: Proses penanganan dan terapi medis bagi korban narkotika.',
            ],

            // Pasangan 22: Pertolongan & Kerukunan
            [
                'word' => 'BANTU',
                'hint' => 'Memberikan pertolongan kepada orang yang sedang kesusahan (5 huruf).',
                'category' => 'Dukungan Sosial',
                'definition' => 'BANTU: Memberikan uluran tangan untuk mengarahkan pengguna ke balai rehabilitasi.',
            ],
            [
                'word' => 'RUKUN',
                'hint' => 'Hidup damai dan tenteram bersama keluarga tanpa pertengkaran (5 huruf).',
                'category' => 'Keluarga',
                'definition' => 'RUKUN: Hubungan keluarga harmonis yang menjadi tempat aman bagi anak bertumbuh.',
            ],

            // Pasangan 23: Kecerdasan & Organ Hati
            [
                'word' => 'CERDAS',
                'hint' => 'Pikiran pintar dan cerdik dalam memilih jalan hidup yang benar (6 huruf).',
                'category' => 'Kecerdasan Mental',
                'definition' => 'CERDAS: Kemampuan membedakan hal baik dan buruk demi masa depan.',
            ],
            [
                'word' => 'HATI',
                'hint' => 'Organ penting di dalam tubuh yang bertugas menyaring racun (4 huruf).',
                'category' => 'Organ Tubuh',
                'definition' => 'HATI: Organ tubuh penyaring zat toksik yang bisa rusak akibat narkotika.',
            ],

            // Pasangan 24: Organ Paru & Pengedar
            [
                'word' => 'PARU',
                'hint' => 'Organ pernapasan di rongga dada yang rusak akibat asap rokok (4 huruf).',
                'category' => 'Organ Pernapasan',
                'definition' => 'PARU: Organ penukar oksigen yang rentan rusak akibat zat hisap berbahaya.',
            ],
            [
                'word' => 'BANDAR',
                'hint' => 'Bos besar pelaku peredaran gelap narkoba yang diburu polisi (6 huruf).',
                'category' => 'Sindikat Gelap',
                'definition' => 'BANDAR: Pelaku tindak pidana peredaran gelap yang merusak masa depan generasi bangsa.',
            ],

            // Pasangan 25: Pasien & Dokter
            [
                'word' => 'PASIEN',
                'hint' => 'Orang sakit yang sedang menjalani pengobatan dan dirawat dokter (6 huruf).',
                'category' => 'Rehabilitasi',
                'definition' => 'PASIEN: Individu yang menerima pendampingan dokter dan konselor untuk pulih.',
            ],
            [
                'word' => 'DOKTER',
                'hint' => 'Tenaga medis profesional yang memeriksa dan mengobati orang sakit (6 huruf).',
                'category' => 'Tenaga Medis',
                'definition' => 'DOKTER: Tenaga kesehatan berkeahlian medis yang menangani detoksifikasi pasien.',
            ],

            // Pasangan 26: Terapi & Menjaga Diri
            [
                'word' => 'TERAPI',
                'hint' => 'Metode pengobatan dan latihan medis untuk memulihkan pecandu (6 huruf).',
                'category' => 'Metode Pemulihan',
                'definition' => 'TERAPI: Rangkaian pengobatan perilaku dan medis agar pasien kembali mandiri.',
            ],
            [
                'word' => 'JAGA',
                'hint' => 'Menjaga dan melindungi diri serta keluarga agar tetap selamat (4 huruf).',
                'category' => 'Kewaspadaan',
                'definition' => 'JAGA: Sikap mawas diri untuk memelihara kehormatan dan kesehatan diri.',
            ],

            // Pasangan 27: Bersih Lingkungan & Waktu
            [
                'word' => 'BERSIH',
                'hint' => 'Keadaan tubuh dan lingkungan yang bebas dari kotoran dan narkoba (6 huruf).',
                'category' => 'Desa Bersinar',
                'definition' => 'BERSIH: Kondisi bebas narkotika seperti dalam program Desa Bersinar BNN.',
            ],
            [
                'word' => 'MASA',
                'hint' => 'Waktu atau zaman perjalanan hidup manusia (4 huruf).',
                'category' => 'Masa Depan',
                'definition' => 'MASA: Perjalanan waktu hidup yang harus diisi karya dan prestasi.',
            ],

            // Pasangan 28: Hari Depan & Kesuksesan
            [
                'word' => 'DEPAN',
                'hint' => 'Hari esok atau masa yang akan datang, lawan kata dari belakang (5 huruf).',
                'category' => 'Cita-cita',
                'definition' => 'DEPAN: Hari esok yang penuh peluang cerah bagi generasi yang berprestasi.',
            ],
            [
                'word' => 'SUKSES',
                'hint' => 'Berhasil meraih cita-cita dan prestasi yang dibanggakan (6 huruf).',
                'category' => 'Prestasi',
                'definition' => 'SUKSES: Puncak pencapaian karir dan prestasi yang diraih dengan kejujuran.',
            ],

            // Pasangan 29: Kebanggaan & Kejujuran
            [
                'word' => 'BANGGA',
                'hint' => 'Perasaan senang dan puas di hati atas prestasi yang diraih (6 huruf).',
                'category' => 'Kebanggaan',
                'definition' => 'BANGGA: Rasa hormat dan sukacita orang tua atas prestasi buah hatinya.',
            ],
            [
                'word' => 'JUJUR',
                'hint' => 'Berkata apa adanya sesuai fakta dan tidak berbohong (5 huruf).',
                'category' => 'Karakter Moral',
                'definition' => 'JUJUR: Sikap berterus terang yang menjauhkan seseorang dari perbuatan terlarang.',
            ],

            // Pasangan 30: Keberanian & Kesembuhan
            [
                'word' => 'BERANI',
                'hint' => 'Tidak takut menolak hal buruk, lawan kata dari penakut (6 huruf).',
                'category' => 'Karakter Tangguh',
                'definition' => 'BERANI: Keteguhan tekad untuk menolak bujukan kawan yang menyesatkan.',
            ],
            [
                'word' => 'SEMBUH',
                'hint' => 'Keadaan pulih dan sehat kembali dari penyakit (6 huruf).',
                'category' => 'Pemulihan',
                'definition' => 'SEMBUH: Keadaan pulih seutuhnya dari belenggu penyakit adiksi.',
            ],

            // Pasangan 31: Kebugaran & Kedamaian
            [
                'word' => 'BUGAR',
                'hint' => 'Kondisi fisik segar, fit, dan penuh stamina (5 huruf).',
                'category' => 'Kesehatan Jasmani',
                'definition' => 'BUGAR: Stamina fisik prima yang diperoleh melalui olahraga dan istirahat.',
            ],
            [
                'word' => 'DAMAI',
                'hint' => 'Suasana tenteram dan tenang tanpa ada keributan atau kekacauan (5 huruf).',
                'category' => 'Kedamaian Hati',
                'definition' => 'DAMAI: Ketenteraman batin yang dirasakan orang yang hidup lurus dan sehat.',
            ],

            // Pasangan 32: Kepintaran & Kasih Sayang
            [
                'word' => 'PINTAR',
                'hint' => 'Pandai dan cerdik dalam belajar di sekolah, lawan kata bodoh (6 huruf).',
                'category' => 'Intelektualitas',
                'definition' => 'PINTAR: Menggunakan akal budi untuk melindungi diri dari tipu daya narkoba.',
            ],
            [
                'word' => 'KASIH',
                'hint' => 'Perasaan sayang dan cinta yang tulus kepada sesama (5 huruf).',
                'category' => 'Kasih Keluarga',
                'definition' => 'KASIH: Kehangatan hubungan keluarga yang menjadi penyejuk hati anak muda.',
            ],

            // Pasangan 33: Perhatian & Rumah
            [
                'word' => 'SAYANG',
                'hint' => 'Cinta dan perhatian tulus dari orang tua kepada anaknya (6 huruf).',
                'category' => 'Kasih Keluarga',
                'definition' => 'SAYANG: Cinta tanpa syarat dari keluarga yang menguatkan mental anak.',
            ],
            [
                'word' => 'RUMAH',
                'hint' => 'Tempat tinggal dan bernaung bersama keluarga tempat kita pulang (5 huruf).',
                'category' => 'Tempat Tinggal',
                'definition' => 'RUMAH: Lingkungan pertama pembentuk watak dan kepribadian generasi muda.',
            ],

            // Pasangan 34: Orang Tua Tercinta
            [
                'word' => 'MAMA',
                'hint' => 'Ibu tercinta yang melahirkan dan membesarkan anak-anaknya (4 huruf).',
                'category' => 'Orang Tua',
                'definition' => 'MAMA: Sosok penyayang yang senantiasa menjaga keselamatan keluarga.',
            ],
            [
                'word' => 'PAPA',
                'hint' => 'Ayah tercinta yang menjadi kepala keluarga pelindung rumah (4 huruf).',
                'category' => 'Orang Tua',
                'definition' => 'PAPA: Kepala keluarga yang menjadi teladan hidup jujur dan bertanggung jawab.',
            ],

            // Pasangan 35: Generasi Anak & Lingkungan Kota
            [
                'word' => 'ANAK',
                'hint' => 'Putra atau putri buah hati kesayangan orang tua (4 huruf).',
                'category' => 'Generasi Muda',
                'definition' => 'ANAK: Masa depan bangsa yang wajib dilindungi dari bahaya narkotika.',
            ],
            [
                'word' => 'KOTA',
                'hint' => 'Pusat pemukiman ramai yang banyak gedung dan pertokoan (4 huruf).',
                'category' => 'Wilayah Hukum',
                'definition' => 'KOTA: Pusat peradaban yang harus dijaga ketenteraman dan keamanannya.',
            ],

            // Pasangan 36: Desa & Peran Warga
            [
                'word' => 'DESA',
                'hint' => 'Wilayah perkampungan yang asri, contohnya program Desa Bersinar (4 huruf).',
                'category' => 'Pedesaan',
                'definition' => 'DESA: Komunitas masyarakat yang kokoh menolak masuknya barang terlarang.',
            ],
            [
                'word' => 'WARGA',
                'hint' => 'Penduduk atau masyarakat yang tinggal di suatu lingkungan (5 huruf).',
                'category' => 'Masyarakat',
                'definition' => 'WARGA: Penduduk yang memiliki kepedulian bersama menjaga lingkungannya.',
            ],

            // Pasangan 37: Hakim & Sidang
            [
                'word' => 'HAKIM',
                'hint' => 'Pejabat di pengadilan yang memutuskan vonis hukuman bagi terdakwa (5 huruf).',
                'category' => 'Peradilan',
                'definition' => 'HAKIM: Aparat hukum yang menegakkan keadilan dan memberi sanksi pidana.',
            ],
            [
                'word' => 'SIDANG',
                'hint' => 'Pertemuan resmi di pengadilan untuk memeriksa perkara hukum (6 huruf).',
                'category' => 'Proses Hukum',
                'definition' => 'SIDANG: Pertemuan peradilan resmi untuk membuktikan tindak kejahatan.',
            ],

            // Pasangan 38: Vonis & Jerat
            [
                'word' => 'VONIS',
                'hint' => 'Keputusan hukuman resmi dari hakim di persidangan (5 huruf).',
                'category' => 'Sanksi Hukum',
                'definition' => 'VONIS: Penetapan hukuman pidana yang dijatuhkan hakim kepada terpidana.',
            ],
            [
                'word' => 'JERAT',
                'hint' => 'Perangkap atau jebakan yang mengikat korban narkoba (5 huruf).',
                'category' => 'Bahaya Adiksi',
                'definition' => 'JERAT: Ikatan kecanduan yang membuat pemakai narkoba sulit melepaskan diri.',
            ],

            // Pasangan 39: Jebakan & Rayuan
            [
                'word' => 'JEBAK',
                'hint' => 'Perangkap tipu muslihat sindikat untuk menjerat pemula (5 huruf).',
                'category' => 'Modus Operandi',
                'definition' => 'JEBAK: Perangkap tipu muslihat sindikat untuk mendapatkan korban baru.',
            ],
            [
                'word' => 'RAYU',
                'hint' => 'Bujukan manis pengedar untuk memikat calon pembeli narkoba (4 huruf).',
                'category' => 'Bujukan Negatif',
                'definition' => 'RAYU: Perkataan manipulatif pengedar yang menipu calon korban pemula.',
            ],

            // Pasangan 40: Penyesalan Diri & Kerugian
            [
                'word' => 'SESAL',
                'hint' => 'Rasa kecewa mendalam yang datang terlambat setelah berbuat salah (5 huruf).',
                'category' => 'Penyesalan Diri',
                'definition' => 'SESAL: Perasaan duka mendalam saat menyadari narkoba menghancurkan masa depan.',
            ],
            [
                'word' => 'RUGI',
                'hint' => 'Kehilangan uang dan masa depan sia-sia, lawan kata dari untung (4 huruf).',
                'category' => 'Dampak Ekonomi',
                'definition' => 'RUGI: Kerugian harta dan masa muda yang sia-sia karena membeli zat terlarang.',
            ],

            // Pasangan 41: Kehancuran & Tekad
            [
                'word' => 'HANCUR',
                'hint' => 'Kondisi rusak binasa sama sekali akibat kecanduan zat terlarang (6 huruf).',
                'category' => 'Dampak Fatal',
                'definition' => 'HANCUR: Kehancuran cita-cita dan kehormatan keluarga akibat adiksi obat.',
            ],
            [
                'word' => 'TEKAD',
                'hint' => 'Kemauan yang bulat dan teguh di dalam hati untuk hidup bersih (5 huruf).',
                'category' => 'Niat Baik',
                'definition' => 'TEKAD: Ketetapan hati yang teguh untuk hidup bersih dan penuh manfaat.',
            ],

            // Pasangan 42: Janji & Cita-cita
            [
                'word' => 'JANJI',
                'hint' => 'Komitmen sumpah pada diri sendiri yang wajib ditepati (5 huruf).',
                'category' => 'Komitmen',
                'definition' => 'JANJI: Ikrar setia untuk membahagiakan orang tua tanpa menyentuh narkoba.',
            ],
            [
                'word' => 'CITA',
                'hint' => 'Impian luhur masa depan yang ingin diraih dengan kerja keras (4 huruf).',
                'category' => 'Cita-cita',
                'definition' => 'CITA: Keinginan mulia meraih kesuksesan yang wajib dijaga dari narkoba.',
            ],

            // Pasangan 43: Impian & Kebenaran
            [
                'word' => 'MIMPI',
                'hint' => 'Khayalan tidur atau cita-cita yang ingin dicapai saat bangun (5 huruf).',
                'category' => 'Harapan',
                'definition' => 'MIMPI: Visi hari esok yang terang benderang bagi pemuda yang bersih raga dan jiwa.',
            ],
            [
                'word' => 'BENAR',
                'hint' => 'Sesuai dengan kenyataan dan aturan yang sah, lawan kata dari salah (5 huruf).',
                'category' => 'Kebenaran',
                'definition' => 'BENAR: Berpegang teguh pada prinsip kebenaran dan kejujuran hidup.',
            ],

            // Pasangan 44: Prestasi Gemilang (HARI INI / DAY 294)
            [
                'word' => 'JUARA',
                'hint' => 'Pemenang peringkat pertama dalam lomba atau kompetisi (5 huruf).',
                'category' => 'Prestasi',
                'definition' => 'JUARA: Pemenang kehidupan yang berhasil menaklukkan godaan dan berprestasi.',
            ],
            [
                'word' => 'HEBAT',
                'hint' => 'Luar biasa dan mengagumkan dalam mengukir prestasi diri (5 huruf).',
                'category' => 'Prestasi Diri',
                'definition' => 'HEBAT: Kemampuan anak bangsa berprestasi puncak tanpa obat terlarang.',
            ],

            // Pasangan 45: Keadilan & Budi Pekerti
            [
                'word' => 'ADIL',
                'hint' => 'Sikap seimbang dan tidak memihak, lawan kata dari curang (4 huruf).',
                'category' => 'Keadilan',
                'definition' => 'ADIL: Menegakkan hukum secara seimbang demi kepastian dan keadilan.',
            ],
            [
                'word' => 'BAIK',
                'hint' => 'Perilaku terpuji dan ramah, lawan kata dari jahat atau buruk (4 huruf).',
                'category' => 'Budi Pekerti',
                'definition' => 'BAIK: Akhlak mulia yang membentengi diri dari pergaulan menyimpang.',
            ],

            // Pasangan 46: Kebugaran & Keyakinan
            [
                'word' => 'SEGAR',
                'hint' => 'Kondisi tubuh fit dan bersemangat setelah berolahraga (5 huruf).',
                'category' => 'Kebugaran',
                'definition' => 'SEGAR: Stamina jasmani bugar alami tanpa stimulan kimiawi buatan.',
            ],
            [
                'word' => 'YAKIN',
                'hint' => 'Percaya diri dan mantap di hati bahwa kita bisa sukses (5 huruf).',
                'category' => 'Keyakinan',
                'definition' => 'YAKIN: Rasa percaya diri yang tinggi dalam menggapai masa depan cerah.',
            ],

            // Pasangan 47: Kegembiraan & Ketaatan
            [
                'word' => 'CERIA',
                'hint' => 'Suasana hati bergembira dan riang tanpa rasa murung (5 huruf).',
                'category' => 'Kesehatan Mental',
                'definition' => 'CERIA: Kegembiraan alami bersama keluarga dan sahabat tanpa zat kimia.',
            ],
            [
                'word' => 'PATUH',
                'hint' => 'Taat dan patuh pada aturan hukum serta nasihat orang tua (5 huruf).',
                'category' => 'Ketaatan',
                'definition' => 'PATUH: Sikap disiplin menghormati hukum negara dan norma keluarga.',
            ],

            // Pasangan 48: Ketertiban & Kewaspadaan
            [
                'word' => 'TERTIB',
                'hint' => 'Rapi dan teratur menjalankan aturan dalam hidup bermasyarakat (6 huruf).',
                'category' => 'Ketertiban',
                'definition' => 'TERTIB: Suasana lingkungan yang taat hukum, aman, dan tenteram.',
            ],
            [
                'word' => 'AWAS',
                'hint' => 'Hati-hati dan waspada terhadap bahaya di sekeliling kita (4 huruf).',
                'category' => 'Kewaspadaan',
                'definition' => 'AWAS: Sikap waspada mengenali modus baru peredaran sindikat narkotika.',
            ],

            // Pasangan 49: Ketanggapan & Kebersamaan
            [
                'word' => 'SIGAP',
                'hint' => 'Cepat tanggap dan gesit dalam bertindak mencegah marabahaya (5 huruf).',
                'category' => 'Ketanggapan',
                'definition' => 'SIGAP: Tindakan cepat warga dalam melapor dugaan peredaran obat terlarang.',
            ],
            [
                'word' => 'SOLID',
                'hint' => 'Kompak dan bersatu padu bersama kawan melawan peredaran gelap (5 huruf).',
                'category' => 'Kebersamaan',
                'definition' => 'SOLID: Kekuatan persaudaraan warga menjaga desa tetap bersih narkoba.',
            ],

            // Pasangan 50: Ketulusan & Kemuliaan
            [
                'word' => 'IKHLAS',
                'hint' => 'Tulus hati tanpa pamrih dalam menolong sesama yang membutuhkan (6 huruf).',
                'category' => 'Ketulusan',
                'definition' => 'IKHLAS: Niat tulus mengulurkan tangan membantu korban penyalahgunaan zat.',
            ],
            [
                'word' => 'MULIA',
                'hint' => 'Terpuji dan berharga di mata masyarakat dan Tuhan (5 huruf).',
                'category' => 'Kemuliaan Hidup',
                'definition' => 'MULIA: Hidup bermartabat dengan karya nyata dan bersih dari narkotika.',
            ],
        ];

        foreach ($words as $item) {
            GameWordle::create([
                'word' => strtoupper($item['word']),
                'length' => strlen($item['word']),
                'hint' => $item['hint'],
                'definition' => $item['definition'],
                'category' => $item['category'],
                'is_active' => true,
            ]);
        }
    }
}
