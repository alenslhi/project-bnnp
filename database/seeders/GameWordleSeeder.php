<?php

namespace Database\Seeders;

use App\Models\GameWordle;
use Illuminate\Database\Seeder;

class GameWordleSeeder extends Seeder
{
    public function run(): void
    {
        GameWordle::truncate();

        $words = array (
  0 => 
  array (
    'word' => 'CANDU',
    'hint' => 'Rasa ketagihan yang bikin pengen pakai narkoba terus-menerus (5 huruf).',
    'category' => 'Adiksi',
    'definition' => 'CANDU: Keterikatan fisik dan psikologis akut akibat zat adiktif pada otak.',
  ),
  1 => 
  array (
    'word' => 'REHAB',
    'hint' => 'Tempat atau layanan perawatan pemulihan resmi BNN untuk pecandu (5 huruf).',
    'category' => 'Pemulihan',
    'definition' => 'REHAB: Layanan medis dan sosial terpadu BNN agar pecandu pulih seutuhnya.',
  ),
  2 => 
  array (
    'word' => 'SAKAW',
    'hint' => 'Rasa sakit menyiksa saat tubuh pecandu mendadak putus zat narkoba (5 huruf).',
    'category' => 'Gejala Putus Zat',
    'definition' => 'SAKAW: Gejala fisik menyiksa saat tubuh tidak mendapat pasokan zat adiktif.',
  ),
  3 => 
  array (
    'word' => 'OTAK',
    'hint' => 'Organ vital di kepala yang fungsi nalar dan sarafnya dirusak narkoba (4 huruf).',
    'category' => 'Organ Vital',
    'definition' => 'OTAK: Pusat kendali tubuh dan memori yang sel sarafnya dirusak narkotika.',
  ),
  4 => 
  array (
    'word' => 'SABU',
    'hint' => 'Narkotika jenis kristal putih stimulan yang dihisap dengan alat bong (4 huruf).',
    'category' => 'Jenis Narkotika',
    'definition' => 'SABU: Metamfetamin kristal yang merusak susunan saraf pusat dan memicu paranoia.',
  ),
  5 => 
  array (
    'word' => 'RACUN',
    'hint' => 'Zat berbahaya dalam narkoba yang merusak organ tubuh manusia (5 huruf).',
    'category' => 'Bahaya Fisik',
    'definition' => 'RACUN: Bahan kimia destruktif di dalam narkoba perusak organ vital tubuh.',
  ),
  6 => 
  array (
    'word' => 'BONG',
    'hint' => 'Alat hisap rakitan botol air yang biasa dipakai pengisap kristal sabu (4 huruf).',
    'category' => 'Alat Narkoba',
    'definition' => 'BONG: Perangkat hisap pipa air yang digunakan untuk membakar kristal metamfetamin.',
  ),
  7 => 
  array (
    'word' => 'PIPET',
    'hint' => 'Pipa kaca kecil silinder yang dipakai membakar kristal sabu (5 huruf).',
    'category' => 'Alat Narkoba',
    'definition' => 'PIPET: Tabung kaca kecil untuk memanaskan kristal sabu saat dihisap.',
  ),
  8 => 
  array (
    'word' => 'GANJA',
    'hint' => 'Tanaman terlarang dengan daun hijau menjari yang sering dilinting (5 huruf).',
    'category' => 'Jenis Narkotika',
    'definition' => 'GANJA: Tanaman Cannabis sativa golongan I yang dilarang keras berdasarkan UU.',
  ),
  9 => 
  array (
    'word' => 'SINTE',
    'hint' => 'Tembakau sintetis berbahaya semprotan bahan kimia buatan (5 huruf).',
    'category' => 'Narkoba Sintetis',
    'definition' => 'SINTE: Daun yang disemprot cairan kimia kanabinoid sintetis pemicu kejang dan serangan jantung.',
  ),
  10 => 
  array (
    'word' => 'TELER',
    'hint' => 'Kondisi mabuk linglung dan hilang koordinasi fisik akibat zat narkoba (5 huruf).',
    'category' => 'Efek Narkoba',
    'definition' => 'TELER: Keadaan tidak sadar penuh dan linglung akibat pengaruh zat psikoaktif.',
  ),
  11 => 
  array (
    'word' => 'VAPE',
    'hint' => 'Rokok elektrik yang cairannya kini rawan disusupi narkotika sintetis (4 huruf).',
    'category' => 'Modus Kamuflase',
    'definition' => 'VAPE: Perangkat uap elektrik yang marak disalahgunakan untuk liquid narkotika.',
  ),
  12 => 
  array (
    'word' => 'JARUM',
    'hint' => 'Benda tajam runcing pada alat suntik narkoba penular virus HIV (5 huruf).',
    'category' => 'Alat Berbahaya',
    'definition' => 'JARUM: Media penularan virus mematikan bila disalahgunakan bergantian oleh pecandu.',
  ),
  13 => 
  array (
    'word' => 'MORFIN',
    'hint' => 'Obat pereda nyeri keras dari getah opium yang diawasi sangat ketat (6 huruf).',
    'category' => 'Golongan Opiat',
    'definition' => 'MORFIN: Alkaloid analgesik kuat dari opium yang hanya boleh untuk indikasi medis khusus.',
  ),
  14 => 
  array (
    'word' => 'OPIUM',
    'hint' => 'Getah mentah tanaman Papaver somniferum bahan baku morfin dan heroin (5 huruf).',
    'category' => 'Golongan Opiat',
    'definition' => 'OPIUM: Bahan baku alami opiat yang menjadi asal mula berbagai obat terlarang.',
  ),
  15 => 
  array (
    'word' => 'KOMA',
    'hint' => 'Kondisi pingsan dan hilang kesadaran stadium akhir akibat overdosis (4 huruf).',
    'category' => 'Risiko Fatal',
    'definition' => 'KOMA: Hilangnya kesadaran mendalam akibat keracunan zat adiktif yang melumpuhkan otak.',
  ),
  16 => 
  array (
    'word' => 'OBAT',
    'hint' => 'Bahan medis yang berbahaya bila disalahgunakan tanpa resep dokter (4 huruf).',
    'category' => 'Farmakologi',
    'definition' => 'OBAT: Sediaan kimia medis yang dapat memicu kecanduan bila dikonsumsi sembarangan.',
  ),
  17 => 
  array (
    'word' => 'HIRUP',
    'hint' => 'Menghisap uap lem perekat (inhalan) yang mematikan sel-sel saraf otak (5 huruf).',
    'category' => 'Modus Inhalan',
    'definition' => 'HIRUP: Cara penyalahgunaan zat pelarut kimia uap lem yang membunuh sel-sel saraf otak.',
  ),
  18 => 
  array (
    'word' => 'KOKAIN',
    'hint' => 'Serbuk putih stimulan dari daun tanaman koka perusak pembuluh darah (6 huruf).',
    'category' => 'Jenis Narkotika',
    'definition' => 'KOKAIN: Alkaloid stimulan kuat dari tanaman koka yang memicu vasokonstriksi jantung.',
  ),
  19 => 
  array (
    'word' => 'KIMIA',
    'hint' => 'Senyawa sintetis buatan pabrik dalam campuran narkoba terlarang (5 huruf).',
    'category' => 'Zat Berbahaya',
    'definition' => 'KIMIA: Bahan sintetis ilegal yang diracik tanpa standar farmasi di lab gelap.',
  ),
  20 => 
  array (
    'word' => 'BANDAR',
    'hint' => 'Bos besar pengendali dan pemodal peredaran gelap narkoba (6 huruf).',
    'category' => 'Sindikat Gelap',
    'definition' => 'BANDAR: Pelaku tindak pidana peredaran gelap yang diancam hukuman pidana mati.',
  ),
  21 => 
  array (
    'word' => 'KURIR',
    'hint' => 'Orang suruhan sindikat yang mengantarkan paket barang narkoba (5 huruf).',
    'category' => 'Sindikat Gelap',
    'definition' => 'KURIR: Pengantar narkotika yang tetap dijatuhi sanksi pidana penjara sangat berat.',
  ),
  22 => 
  array (
    'word' => 'HUKUM',
    'hint' => 'Peraturan resmi negara yang memberi sanksi tegas bagi pelaku narkoba (5 huruf).',
    'category' => 'Regulasi',
    'definition' => 'HUKUM: Ketetapan perundang-undangan pidana yang menindak tegas kejahatan narkotika.',
  ),
  23 => 
  array (
    'word' => 'RAZIA',
    'hint' => 'Operasi pemeriksaan serentak aparat untuk menjaring peredaran narkoba (5 huruf).',
    'category' => 'Penegakan Hukum',
    'definition' => 'RAZIA: Tindakan penggeledahan dan pemeriksaan urine serentak di tempat rawan narkoba.',
  ),
  24 => 
  array (
    'word' => 'PULIH',
    'hint' => 'Keadaan sembuh dan bisa hidup normal kembali setelah berhenti narkoba (5 huruf).',
    'category' => 'Pemulihan',
    'definition' => 'PULIH: Kondisi keberhasilan mantan pengguna terbebas dari jeratan adiksi obat.',
  ),
  25 => 
  array (
    'word' => 'TERAPI',
    'hint' => 'Metode pengobatan medis dan psikologis untuk memulihkan pecandu (6 huruf).',
    'category' => 'Layanan Medis',
    'definition' => 'TERAPI: Rangkaian pemulihan perilaku dan medis agar pasien adiksi kembali mandiri.',
  ),
  26 => 
  array (
    'word' => 'URIN',
    'hint' => 'Sampel air seni yang diperiksa pada tes uji skrining narkoba (4 huruf).',
    'category' => 'Pemeriksaan Medis',
    'definition' => 'URIN: Sampel biologis utama untuk mendeteksi keberadaan metabolit zat narkotika.',
  ),
  27 => 
  array (
    'word' => 'BEBAS',
    'hint' => 'Kondisi merdeka dan terlepas seutuhnya dari jeratan belenggu narkoba (5 huruf).',
    'category' => 'Masa Depan',
    'definition' => 'BEBAS: Keadaan merdeka tanpa kecanduan untuk berkarya dan meraih cita-cita masa depan.',
  ),
  28 => 
  array (
    'word' => 'DARAH',
    'hint' => 'Cairan tubuh yang tercemar racun saat seseorang mengonsumsi narkoba (5 huruf).',
    'category' => 'Organ Tubuh',
    'definition' => 'DARAH: Cairan pengalir oksigen yang menyerap racun narkotika ke seluruh tubuh.',
  ),
  29 => 
  array (
    'word' => 'SUNTIK',
    'hint' => 'Cara memasukkan zat cair narkoba langsung ke pembuluh darah vena (6 huruf).',
    'category' => 'Modus Konsumsi',
    'definition' => 'SUNTIK: Metode pemakaian narkoba cair dengan jarum berisiko tinggi HIV dan overdosis.',
  ),
  30 => 
  array (
    'word' => 'KRAM',
    'hint' => 'Kejang kaku dan nyeri hebat pada otot tubuh saat pecandu putus zat (4 huruf).',
    'category' => 'Gejala Fisik',
    'definition' => 'KRAM: Kontraksi otot menyakitkan yang timbul saat tubuh pecandu mengalami sakaw.',
  ),
  31 => 
  array (
    'word' => 'BADAN',
    'hint' => 'Fisik raga manusia yang kurus kering dan rusak akibat zat adiktif (5 huruf).',
    'category' => 'Kondisi Jasmani',
    'definition' => 'BADAN: Struktur fisik raga yang mengalami penurunan daya tahan akibat racun narkotika.',
  ),
  32 => 
  array (
    'word' => 'STRES',
    'hint' => 'Beban pikiran berat yang tidak boleh dilampiaskan ke narkoba (5 huruf).',
    'category' => 'Kesehatan Jiwa',
    'definition' => 'STRES: Tekanan emosional yang harus diatasi dengan pola hidup positif, bukan obat.',
  ),
  33 => 
  array (
    'word' => 'PANIK',
    'hint' => 'Rasa cemas dan ketakutan hebat saat tubuh pecandu putus obat penenang (5 huruf).',
    'category' => 'Kesehatan Jiwa',
    'definition' => 'PANIK: Serangan kecemasan akut yang menyertai sindrom putus zat obat penenang.',
  ),
  34 => 
  array (
    'word' => 'SADAR',
    'hint' => 'Kondisi pikiran jernih, lawan kata dari pingsan atau teler (5 huruf).',
    'category' => 'Sikap Diri',
    'definition' => 'SADAR: Keadaan terjaga dan memahami bahaya narkotika bagi diri dan keluarga.',
  ),
  35 => 
  array (
    'word' => 'WARAS',
    'hint' => 'Pikiran sehat dan berakal budi, lawan kata dari hilang akal (5 huruf).',
    'category' => 'Kesehatan Jiwa',
    'definition' => 'WARAS: Kondisi akal budi sehat dan mampu berpikir rasional tanpa zat memabukkan.',
  ),
  36 => 
  array (
    'word' => 'ROKOK',
    'hint' => 'Batang tembakau hisap berpuntung pintu masuk awal mencoba narkoba (5 huruf).',
    'category' => 'Pintu Masuk',
    'definition' => 'ROKOK: Zat adiktif nikotin yang kerap menjadi gerbang awal mencoba obat terlarang.',
  ),
  37 => 
  array (
    'word' => 'TOLAK',
    'hint' => 'Sikap tegas menyatakan tidak mau saat ditawari narkoba, lawan terima (5 huruf).',
    'category' => 'Pencegahan',
    'definition' => 'TOLAK: Sikap tegas tidak kompromi terhadap segala bentuk tawaran zat terlarang.',
  ),
  38 => 
  array (
    'word' => 'BAHAYA',
    'hint' => 'Kondisi tidak aman dan berisiko mencelakakan tubuh akibat narkoba (6 huruf).',
    'category' => 'Edukasi Risiko',
    'definition' => 'BAHAYA: Segala ancaman kerusakan fisik, mental, dan masa depan akibat narkoba.',
  ),
  39 => 
  array (
    'word' => 'CEGAH',
    'hint' => 'Tindakan membentengi diri sebelum terlanjur terjerumus narkoba (5 huruf).',
    'category' => 'Pencegahan',
    'definition' => 'CEGAH: Upaya preventif menjauhkan generasi muda dari ancaman narkotika.',
  ),
  40 => 
  array (
    'word' => 'HEROIN',
    'hint' => 'Narkotika serbuk putih sangat adiktif turunan morfin (putaw) (6 huruf).',
    'category' => 'Golongan Opiat',
    'definition' => 'HEROIN: Serbuk putih perusak sistem saraf yang menekan pusat pernapasan manusia.',
  ),
  41 => 
  array (
    'word' => 'SEHAT',
    'hint' => 'Kondisi tubuh bugar tanpa terpengaruh zat narkoba, lawan kata sakit (5 huruf).',
    'category' => 'Gaya Hidup',
    'definition' => 'SEHAT: Keadaan bugar dan seimbang fisik mental tanpa ketergantungan obat terlarang.',
  ),
  42 => 
  array (
    'word' => 'PUTAW',
    'hint' => 'Istilah jalanan populer untuk narkotika jenis serbuk heroin (5 huruf).',
    'category' => 'Golongan Opiat',
    'definition' => 'PUTAW: Sebutan populer heroin kelas jalanan yang kerap dikonsumsi secara suntik.',
  ),
  43 => 
  array (
    'word' => 'PARU',
    'hint' => 'Organ pernapasan di rongga dada yang rusak akibat hisapan zat terlarang (4 huruf).',
    'category' => 'Organ Tubuh',
    'definition' => 'PARU: Organ penukar oksigen yang rentan mengalami infeksi dan kerusakan jaringan akibat zat hisap.',
  ),
  44 => 
  array (
    'word' => 'JAUHI',
    'hint' => 'Perintah untuk menjaga jarak dan tidak mendekati narkoba (5 huruf).',
    'category' => 'Pencegahan',
    'definition' => 'JAUHI: Komitmen teguh untuk menjaga jarak dari pergaulan dan peredaran narkoba.',
  ),
  45 => 
  array (
    'word' => 'RAWAT',
    'hint' => 'Menjaga dan mengobati pecandu agar lekas pulih dari ketergantungan (5 huruf).',
    'category' => 'Layanan Medis',
    'definition' => 'RAWAT: Proses terapi medis komprehensif bagi korban penyalahgunaan narkotika.',
  ),
  46 => 
  array (
    'word' => 'BANTU',
    'hint' => 'Pertolongan mengarahkan korban narkoba untuk melapor ke tempat rehab (5 huruf).',
    'category' => 'Dukungan Sosial',
    'definition' => 'BANTU: Memberikan uluran tangan untuk menyelamatkan korban ketergantungan zat.',
  ),
  47 => 
  array (
    'word' => 'POLISI',
    'hint' => 'Aparat penegak hukum berseragam yang menangkap bandar narkoba (6 huruf).',
    'category' => 'Penegakan Hukum',
    'definition' => 'POLISI: Penegak hukum yang bertugas memberantas peredaran gelap narkoba.',
  ),
  48 => 
  array (
    'word' => 'RUSAK',
    'hint' => 'Kondisi organ tubuh dan sel saraf yang hancur akibat zat berbahaya (5 huruf).',
    'category' => 'Dampak Narkoba',
    'definition' => 'RUSAK: Kehancuran sel otak dan organ vital akibat pengaruh racun narkotika.',
  ),
  49 => 
  array (
    'word' => 'MAUT',
    'hint' => 'Kematian tragis yang selalu mengintai akibat overdosis narkoba (4 huruf).',
    'category' => 'Risiko Fatal',
    'definition' => 'MAUT: Kematian mendadak akibat henti jantung dan gagal napas overdosis.',
  ),
  50 => 
  array (
    'word' => 'VONIS',
    'hint' => 'Keputusan hukuman resmi dari hakim di persidangan kasus narkoba (5 huruf).',
    'category' => 'Sanksi Hukum',
    'definition' => 'VONIS: Penetapan hukuman pidana yang dijatuhkan majelis hakim kepada terdakwa.',
  ),
  51 => 
  array (
    'word' => 'SIDANG',
    'hint' => 'Pertemuan resmi di pengadilan untuk membuktikan tindak pidana narkoba (6 huruf).',
    'category' => 'Proses Hukum',
    'definition' => 'SIDANG: Proses peradilan resmi untuk mengadili pelaku kejahatan narkotika.',
  ),
  52 => 
  array (
    'word' => 'JERAT',
    'hint' => 'Perangkap lingkaran setan adiksi yang mengikat pemakai narkoba (5 huruf).',
    'category' => 'Bahaya Adiksi',
    'definition' => 'JERAT: Ikatan kecanduan yang membuat pemakai narkoba sulit melepaskan diri.',
  ),
  53 => 
  array (
    'word' => 'JEBAK',
    'hint' => 'Tipu muslihat sindikat gelap untuk menjebak remaja menjadi pemakai (5 huruf).',
    'category' => 'Modus Sindikat',
    'definition' => 'JEBAK: Modus operandi pengedar menjerat pengguna baru dengan iming-iming gratis.',
  ),
  54 => 
  array (
    'word' => 'RAYU',
    'hint' => 'Bujukan manis manipulatif pengedar untuk memikat calon pembeli (4 huruf).',
    'category' => 'Modus Sindikat',
    'definition' => 'RAYU: Perkataan manipulatif sindikat narkoba yang menipu generasi muda.',
  ),
  55 => 
  array (
    'word' => 'SESAL',
    'hint' => 'Rasa kecewa mendalam yang selalu datang terlambat setelah pakai narkoba (5 huruf).',
    'category' => 'Penyesalan Diri',
    'definition' => 'SESAL: Perasaan duka mendalam saat menyadari narkoba merusak masa depan.',
  ),
  56 => 
  array (
    'word' => 'RUGI',
    'hint' => 'Kehilangan uang dan masa depan sia-sia karena membeli narkoba (4 huruf).',
    'category' => 'Dampak Ekonomi',
    'definition' => 'RUGI: Kerugian materi dan masa muda yang lenyap akibat membeli obat terlarang.',
  ),
  57 => 
  array (
    'word' => 'HANCUR',
    'hint' => 'Rusak binasa sama sekali cita-cita akibat kecanduan zat terlarang (6 huruf).',
    'category' => 'Dampak Fatal',
    'definition' => 'HANCUR: Kehancuran masa depan dan keluarga akibat keterikatan pada zat adiktif.',
  ),
  58 => 
  array (
    'word' => 'TEKAD',
    'hint' => 'Kemauan kuat di dalam hati untuk menolak segala tawaran narkoba (5 huruf).',
    'category' => 'Ketahanan Diri',
    'definition' => 'TEKAD: Ketetapan hati yang teguh untuk hidup bersih dan penuh karya positif.',
  ),
  59 => 
  array (
    'word' => 'JANJI',
    'hint' => 'Komitmen sumpah pada diri sendiri untuk tidak menyentuh narkotika (5 huruf).',
    'category' => 'Komitmen Diri',
    'definition' => 'JANJI: Ikrar setia menjaga kehormatan diri dan keluarga tanpa narkoba.',
  ),
  60 => 
  array (
    'word' => 'BERSIH',
    'hint' => 'Kondisi lingkungan atau pemukiman yang bebas dari narkoba (6 huruf).',
    'category' => 'Desa Bersinar',
    'definition' => 'BERSIH: Kondisi bebas narkotika dalam gerakan program Desa Bersinar BNN.',
  ),
  61 => 
  array (
    'word' => 'TEGAS',
    'hint' => 'Sikap lugas dan berani menolak ajakan narkoba tanpa ragu-ragu (5 huruf).',
    'category' => 'Karakter Diri',
    'definition' => 'TEGAS: Sikap asertif menolak godaan negatif demi melindungi masa depan.',
  ),
  62 => 
  array (
    'word' => 'AMAN',
    'hint' => 'Lingkungan pemukiman yang tenteram dan bebas dari sarang narkoba (4 huruf).',
    'category' => 'Lingkungan',
    'definition' => 'AMAN: Kondisi tempat tinggal yang terlindung dari bahaya sindikat narkotika.',
  ),
  63 => 
  array (
    'word' => 'HIDUP',
    'hint' => 'Anugerah raga bernyawa yang harus dijaga tanpa racun narkoba (5 huruf).',
    'category' => 'Nilai Kehidupan',
    'definition' => 'HIDUP: Kehidupan berharga yang wajib diisi karya nyata tanpa pengaruh obat.',
  ),
  64 => 
  array (
    'word' => 'KUAT',
    'hint' => 'Ketahanan mental kokoh dalam menolak narkoba, lawan dari lemah (4 huruf).',
    'category' => 'Ketahanan Diri',
    'definition' => 'KUAT: Ketangguhan jiwa dan raga generasi muda dalam membentengi diri.',
  ),
  65 => 
  array (
    'word' => 'TEMAN',
    'hint' => 'Sahabat sebaya yang seharusnya saling mengingatkan jauhi narkoba (5 huruf).',
    'category' => 'Lingkungan Sosial',
    'definition' => 'TEMAN: Sahabat bergaul yang membawa pengaruh positif dalam kehidupan.',
  ),
  66 => 
  array (
    'word' => 'MORAL',
    'hint' => 'Budi pekerti dan benteng etika diri penolak pergaulan bebas (5 huruf).',
    'category' => 'Nilai Etika',
    'definition' => 'MORAL: Budi pekerti luhur yang membimbing manusia untuk senantiasa berbuat baik.',
  ),
  67 => 
  array (
    'word' => 'BOGOR',
    'hint' => 'Kota di Jawa Barat lokasi pusat Balai Besar Rehabilitasi BNN Lido (5 huruf).',
    'category' => 'Pusat Pemulihan',
    'definition' => 'BOGOR: Lokasi Balai Besar Rehabilitasi BNN Lido rujukan pemulihan nasional.',
  ),
  68 => 
  array (
    'word' => 'PARAH',
    'hint' => 'Tingkat kecanduan kronis stadium lanjut yang butuh rawat dokter (5 huruf).',
    'category' => 'Kondisi Medis',
    'definition' => 'PARAH: Tingkat ketergantungan berat yang memerlukan intervensi medis intensif.',
  ),
  69 => 
  array (
    'word' => 'ALAMI',
    'hint' => 'Pola hidup bugar alami dengan olahraga tanpa obat bius kimia (5 huruf).',
    'category' => 'Pola Hidup',
    'definition' => 'ALAMI: Pola hidup murni dengan kebugaran jasmani tanpa zat adiktif.',
  ),
  70 => 
  array (
    'word' => 'HINDAR',
    'hint' => 'Menjauhkan diri dari pergaulan bebas dan tempat peredaran obat (6 huruf).',
    'category' => 'Tindakan Waspada',
    'definition' => 'HINDAR: Tindakan menjauhkan diri dari lingkungan rentan penyalahgunaan zat.',
  ),
  71 => 
  array (
    'word' => 'PEDULI',
    'hint' => 'Perhatian tulus keluarga membantu korban narkoba agar mau direhab (6 huruf).',
    'category' => 'Empati Sosial',
    'definition' => 'PEDULI: Sikap tanggap menolong sesama agar terbebas dari lingkaran narkotika.',
  ),
  72 => 
  array (
    'word' => 'PASIEN',
    'hint' => 'Orang yang sedang menjalani perawatan medis pemulihan dari narkoba (6 huruf).',
    'category' => 'Rehabilitasi',
    'definition' => 'PASIEN: Individu yang menerima pendampingan dokter dan konselor untuk pulih.',
  ),
  73 => 
  array (
    'word' => 'DOKTER',
    'hint' => 'Tenaga medis ahli yang menangani proses detoksifikasi pecandu (6 huruf).',
    'category' => 'Tenaga Medis',
    'definition' => 'DOKTER: Tenaga kesehatan berkeahlian medis yang memeriksa dan mengobati pasien.',
  ),
  74 => 
  array (
    'word' => 'CERDAS',
    'hint' => 'Pikiran kritis dan cerdik agar tidak tertipu bujukan sindikat (6 huruf).',
    'category' => 'Kecerdasan Mental',
    'definition' => 'CERDAS: Kemampuan berpikir jernih membedakan hal baik dan buruk.',
  ),
  75 => 
  array (
    'word' => 'JAGA',
    'hint' => 'Kewajiban menjaga diri dan keluarga dari ancaman barang haram (4 huruf).',
    'category' => 'Kewaspadaan',
    'definition' => 'JAGA: Sikap mawas diri untuk memelihara keselamatan dan kehormatan keluarga.',
  ),
  76 => 
  array (
    'word' => 'BUGAR',
    'hint' => 'Kondisi raga yang segar fit bertenaga tanpa stimulan obat bius (5 huruf).',
    'category' => 'Kesehatan Jasmani',
    'definition' => 'BUGAR: Stamina fisik prima yang diperoleh melalui olahraga dan istirahat cukup.',
  ),
  77 => 
  array (
    'word' => 'DAMAI',
    'hint' => 'Suasana batin tenteram tanpa rasa cemas dikejar aparat hukum (5 huruf).',
    'category' => 'Kedamaian Hati',
    'definition' => 'DAMAI: Ketenteraman batin yang dirasakan orang yang hidup bersih tanpa obat.',
  ),
  78 => 
  array (
    'word' => 'BERANI',
    'hint' => 'Keteguhan tekad berani berkata tidak pada tawaran zat terlarang (6 huruf).',
    'category' => 'Karakter Tangguh',
    'definition' => 'BERANI: Keberanian menolak bujukan kawan yang mengarah pada kejahatan narkoba.',
  ),
  79 => 
  array (
    'word' => 'SEMBUH',
    'hint' => 'Keadaan sehat kembali seutuhnya dari belenggu penyakit adiksi (6 huruf).',
    'category' => 'Pemulihan',
    'definition' => 'SEMBUH: Kondisi terbebas dari penyakit ketergantungan zat berbahaya.',
  ),
  80 => 
  array (
    'word' => 'WARGA',
    'hint' => 'Masyarakat yang berperan aktif melaporkan kejanggalan narkoba (5 huruf).',
    'category' => 'Masyarakat',
    'definition' => 'WARGA: Penduduk yang memiliki kepedulian bersama menjaga lingkungannya.',
  ),
  81 => 
  array (
    'word' => 'HAKIM',
    'hint' => 'Pejabat peradilan yang memberi vonis hukuman bagi bandar narkoba (5 huruf).',
    'category' => 'Peradilan',
    'definition' => 'HAKIM: Aparat penegak hukum yang memimpin sidang dan menjatuhkan sanksi pidana.',
  ),
  82 => 
  array (
    'word' => 'SANKSI',
    'hint' => 'Hukuman pidana berat bagi pelanggar undang-undang narkotika (6 huruf).',
    'category' => 'Sanksi Hukum',
    'definition' => 'SANKSI: Tindakan hukuman tegas bagi pelaku penyalahgunaan dan peredaran narkoba.',
  ),
  83 => 
  array (
    'word' => 'CITA',
    'hint' => 'Impian masa depan gemilang yang akan musnah bila memakai narkoba (4 huruf).',
    'category' => 'Masa Depan',
    'definition' => 'CITA: Keinginan mulia meraih kesuksesan yang wajib dijaga dari jeratan obat.',
  ),
  84 => 
  array (
    'word' => 'MIMPI',
    'hint' => 'Harapan indah masa depan yang harus dilindungi dari bahaya narkotika (5 huruf).',
    'category' => 'Masa Depan',
    'definition' => 'MIMPI: Visi hari esok terang benderang bagi pemuda yang bersih raga dan jiwa.',
  ),
  85 => 
  array (
    'word' => 'PATUH',
    'hint' => 'Taat pada aturan hukum undang-undang narkotika dan nasihat orang tua (5 huruf).',
    'category' => 'Ketaatan',
    'definition' => 'PATUH: Sikap disiplin menghormati hukum negara demi kebaikan diri sendiri.',
  ),
  86 => 
  array (
    'word' => 'TERTIB',
    'hint' => 'Suasana lingkungan yang taat hukum aman dari peredaran narkoba (6 huruf).',
    'category' => 'Ketertiban',
    'definition' => 'TERTIB: Kondisi pemukiman yang mematuhi hukum dan bebas dari kejahatan narkotika.',
  ),
  87 => 
  array (
    'word' => 'AWAS',
    'hint' => 'Sikap waspada mengenali modus baru peredaran gelap narkotika (4 huruf).',
    'category' => 'Kewaspadaan',
    'definition' => 'AWAS: Kewaspadaan tinggi terhadap berbagai tipu muslihat sindikat pengedar.',
  ),
  88 => 
  array (
    'word' => 'SIGAP',
    'hint' => 'Cepat tanggap bertindak melaporkan dugaan peredaran gelap narkoba (5 huruf).',
    'category' => 'Ketanggapan',
    'definition' => 'SIGAP: Tindakan gesit aparat dan warga dalam mencegah masuknya barang haram.',
  ),
  89 => 
  array (
    'word' => 'SOLID',
    'hint' => 'Kompak dan bersatu padu bersama warga membentengi desa dari narkoba (5 huruf).',
    'category' => 'Kebersamaan',
    'definition' => 'SOLID: Kekuatan persatuan masyarakat dalam menjaga lingkungan bersih narkoba.',
  ),
  90 => 
  array (
    'word' => 'LEPAS',
    'hint' => 'Berhasil terlepas dari jeratan lingkaran setan ketergantungan obat (5 huruf).',
    'category' => 'Pemulihan',
    'definition' => 'LEPAS: Keberhasilan melepaskan diri dari belenggu adiksi narkotika.',
  ),
  91 => 
  array (
    'word' => 'MEDIS',
    'hint' => 'Penanganan klinis oleh dokter bagi pemulihan ketergantungan obat (5 huruf).',
    'category' => 'Layanan Medis',
    'definition' => 'MEDIS: Pendekatan kesehatan klinis untuk mengatasi adiksi sebagai penyakit otak.',
  ),
  92 => 
  array (
    'word' => 'KLINIK',
    'hint' => 'Fasilitas kesehatan rujukan tempat pecandu menjalani rawat jalan (6 huruf).',
    'category' => 'Fasilitas Medis',
    'definition' => 'KLINIK: Tempat pelayanan kesehatan pratama BNN untuk rehabilitasi rawat jalan.',
  ),
  93 => 
  array (
    'word' => 'GEJALA',
    'hint' => 'Tanda-tanda perubahan fisik dan emosi pada orang pemakai narkoba (6 huruf).',
    'category' => 'Deteksi Dini',
    'definition' => 'GEJALA: Indikasi perubahan perilaku mencurigakan yang mengarah pada penyalahgunaan zat.',
  ),
  94 => 
  array (
    'word' => 'BAHAN',
    'hint' => 'Zat mentah atau senyawa pemula yang digunakan meracik narkoba (5 huruf).',
    'category' => 'Prekursor',
    'definition' => 'BAHAN: Senyawa kimia pemula (prekursor) yang diawasi ketat peredarannya.',
  ),
  95 => 
  array (
    'word' => 'SIAGA',
    'hint' => 'Sikap siap siaga menjaga pemukiman dari ancaman masuknya pengedar (5 huruf).',
    'category' => 'Kewaspadaan',
    'definition' => 'SIAGA: Kesiapsiagaan warga dalam mengawasi lingkungan tempat tinggalnya.',
  ),
  96 => 
  array (
    'word' => 'HARAP',
    'hint' => 'Asa dan optimisme mantan pecandu untuk memulai lembaran hidup baru (5 huruf).',
    'category' => 'Optimisme',
    'definition' => 'HARAP: Keyakinan cerah menggapai masa depan setelah berhasil pulih dari adiksi.',
  ),
  97 => 
  array (
    'word' => 'BINA',
    'hint' => 'Program pembinaan kemandirian bagi mantan pengguna pascarehabilitasi (4 huruf).',
    'category' => 'Pascarehabilitasi',
    'definition' => 'BINA: Upaya pendampingan berkelanjutan agar mantan pecandu memiliki keahlian kerja.',
  ),
  98 => 
  array (
    'word' => 'PINTAR',
    'hint' => 'Menggunakan akal kepintaran untuk menolak tipu daya kurir narkoba (6 huruf).',
    'category' => 'Intelektualitas',
    'definition' => 'PINTAR: Memanfaatkan kecerdasan untuk melindungi diri dari modus peredaran gelap.',
  ),
  99 => 
  array (
    'word' => 'TEGAK',
    'hint' => 'Berdiri tegak membela kebenaran dan menentang segala wujud narkoba (5 huruf).',
    'category' => 'Prinsip Moral',
    'definition' => 'TEGAK: Prinsip kokoh generasi muda menjunjung tinggi integritas anti-narkotika.',
  ),
);

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
