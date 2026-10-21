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
    'word' => 'THC',
    'hint' => 'Senyawa psikoaktif utama pada tanaman ganja pemicu sensasi euforia dan halusinasi.',
    'category' => 'Zat Psikoaktif',
    'definition' => 'THC: Tetrahidrokanabinol, senyawa kimia kanabinoid utama yang mengubah fungsi kognitif dan memicu ketergantungan.',
  ),
  1 => 
  array (
    'word' => 'LSD',
    'hint' => 'Narkotika sintetis halusinogenik kuat dalam bentuk kertas perangko hisap.',
    'category' => 'Halusinogen',
    'definition' => 'LSD: Asam lisergat dietilamida, zat halusinogen dahsyat yang menyebabkan distorsi persepsi realitas ruang dan waktu.',
  ),
  2 => 
  array (
    'word' => 'OPI',
    'hint' => 'Sebutan getah tanaman candu bahan dasar pembuat morfin dan heroin.',
    'category' => 'Golongan Narkotika',
    'definition' => 'OPI: Singkatan dari opium/opiat, kelompok zat penghilang rasa sakit alami yang memiliki daya adiksi sangat tinggi.',
  ),
  3 => 
  array (
    'word' => 'ZAT',
    'hint' => 'Bahan kimia aktif pembuat ketergantungan fisik dan psikologis.',
    'category' => 'Farmakologi',
    'definition' => 'ZAT: Bahan kimia sintetis atau alami yang mengubah fungsi fisiologis dan psikologis pemakainya.',
  ),
  4 => 
  array (
    'word' => 'PIL',
    'hint' => 'Bentuk sediaan padat obat keras dan psikotropika yang kerap disalahgunakan.',
    'category' => 'Bentuk Sediaan',
    'definition' => 'PIL: Bentuk tablet sediaan obat terlarang seperti ekstasi atau obat penenang ilegal yang diedarkan bandar.',
  ),
  5 => 
  array (
    'word' => 'SABU',
    'hint' => 'Narkotika metamfetamin bentuk kristal putih stimulan kuat susunan saraf.',
    'category' => 'Stimulan',
    'definition' => 'SABU: Metamfetamin kristal golongan I yang merusak sistem dopamin otak dan memicu paranoia akut.',
  ),
  6 => 
  array (
    'word' => 'URIN',
    'hint' => 'Cairan tubuh yang menjadi sampel biologis utama uji skrining tes narkoba.',
    'category' => 'Deteksi & Medis',
    'definition' => 'URIN: Sampel biologis untuk memeriksa metabolit narkotika menggunakan alat tes multi-panel narkoba.',
  ),
  7 => 
  array (
    'word' => 'KOMA',
    'hint' => 'Kondisi hilang kesadaran mendalam akibat keracunan overdosis narkotika.',
    'category' => 'Dampak Medis',
    'definition' => 'KOMA: Kondisi penurunan kesadaran stadium akhir di mana otak mengalami kegagalan fungsi akibat racun zat.',
  ),
  8 => 
  array (
    'word' => 'NODA',
    'hint' => 'Rekam jejak hitam masa depan yang rusak akibat terjerumus lingkaran narkotika.',
    'category' => 'Dampak Sosial',
    'definition' => 'NODA: Catatan kriminal dan kehancuran masa depan yang membayangi penyalah guna narkoba tanpa rehabilitasi.',
  ),
  9 => 
  array (
    'word' => 'OTAK',
    'hint' => 'Organ tubuh vital manusia yang mengalami kerusakan saraf permanen akibat narkotika.',
    'category' => 'Dampak Biologis',
    'definition' => 'OTAK: Pusat pengendali tubuh yang sirkuit penghargaan dan sel neuronnya dirusak oleh zat adiktif.',
  ),
  10 => 
  array (
    'word' => 'URAT',
    'hint' => 'Pembuluh darah vena yang rusak mengeras akibat tusukan jarum suntik narkoba.',
    'category' => 'Dampak Fisik',
    'definition' => 'URAT: Saluran pembuluh darah vena pecandu suntik yang kerap mengalami infeksi abses dan penyumbatan.',
  ),
  11 => 
  array (
    'word' => 'OBAT',
    'hint' => 'Bahan medis kimia yang jika dikonsumsi tanpa resep menjadi racun mematikan.',
    'category' => 'Psikotropika',
    'definition' => 'OBAT: Senyawa farmasi keras seperti tramadol atau penenang yang disalahgunakan di luar indikasi medis.',
  ),
  12 => 
  array (
    'word' => 'MAUT',
    'hint' => 'Kematian tragis yang menjadi ancaman nyata setiap saat bagi pengguna narkoba.',
    'category' => 'Risiko Fatal',
    'definition' => 'MAUT: Risiko fatal kematian mendadak akibat henti napas, henti jantung, atau keracunan zat adiktif.',
  ),
  13 => 
  array (
    'word' => 'BONG',
    'hint' => 'Alat hisap botol air rakitan yang dipakai mengisap asap kristal sabu.',
    'category' => 'Peralatan Narkoba',
    'definition' => 'BONG: Perangkat pipa air yang digunakan untuk menghirup uap narkotika jenis metamfetamin.',
  ),
  14 => 
  array (
    'word' => 'KRAM',
    'hint' => 'Kejang dan nyeri otot hebat yang melanda tubuh saat sakaw putus zat.',
    'category' => 'Gejala Putus Zat',
    'definition' => 'KRAM: Kontraksi otot menyiksa yang timbul saat tubuh pecandu tidak menerima suplai zat adiktif hariannya.',
  ),
  15 => 
  array (
    'word' => 'CANDU',
    'hint' => 'Keterikatan akut dan ketergantungan kronis yang membajak kendali diri pemakai.',
    'category' => 'Adiksi',
    'definition' => 'CANDU: Kondisi ketergantungan berat fisik maupun mental yang membuat seseorang tidak mampu berhenti memakai zat.',
  ),
  16 => 
  array (
    'word' => 'REHAB',
    'hint' => 'Program perawatan medis dan sosial resmi BNN agar pecandu pulih seutuhnya.',
    'category' => 'Pemulihan',
    'definition' => 'REHAB: Rehabilitasi, proses terpadu pemulihan medis, konseling, dan pembinaan agar korban narkoba kembali produktif.',
  ),
  17 => 
  array (
    'word' => 'SAKAW',
    'hint' => 'Kondisi fisik dan mental tersiksa ketika tubuh mendadak kehabisan zat adiktif.',
    'category' => 'Gejala Klinis',
    'definition' => 'SAKAW: Sindrom putus obat (withdrawal) yang disertai nyeri tulang, muntah, menggigil, dan depresi berat.',
  ),
  18 => 
  array (
    'word' => 'GANJA',
    'hint' => 'Tanaman Cannabis sativa narkotika golongan I pembawa kandungan THC terlarang.',
    'category' => 'Narkotika Alami',
    'definition' => 'GANJA: Tanaman terlarang yang memperlambat fungsi otak, merusak daya ingat, dan memicu gangguan psikotik.',
  ),
  19 => 
  array (
    'word' => 'OPIAT',
    'hint' => 'Zat turunan getah candu yang bekerja menekan sistem saraf dan nyeri.',
    'category' => 'Depresan',
    'definition' => 'OPIAT: Golongan senyawa pereda nyeri kuat yang memicu toleransi dosis cepat dan risiko henti napas fatal.',
  ),
  20 => 
  array (
    'word' => 'OPIUM',
    'hint' => 'Getah kering dari tanaman Papaver somniferum bahan dasar morfin dan heroin.',
    'category' => 'Narkotika Alami',
    'definition' => 'OPIUM: Bahan baku alami tertua dalam sejarah narkotika yang getahnya mengandung puluhan alkaloid adiktif.',
  ),
  21 => 
  array (
    'word' => 'RACUN',
    'hint' => 'Zat kimia berbahaya dalam narkotika yang mengendap merusak organ dalam tubuh.',
    'category' => 'Toksisitas',
    'definition' => 'RACUN: Bahan destruktif pada narkotika yang merusak organ hati, ginjal, paru-paru, dan jaringan otak.',
  ),
  22 => 
  array (
    'word' => 'SEHAT',
    'hint' => 'Kondisi bugar fisik, mental, dan sosial yang terbebas dari jeratan zat narkotika.',
    'category' => 'Gaya Hidup',
    'definition' => 'SEHAT: Kondisi prima seutuhnya yang menjadi tujuan utama gerakan hidup bersih anti-narkoba BNN.',
  ),
  23 => 
  array (
    'word' => 'SINTE',
    'hint' => 'Tembakau sintetis semprotan zat kimia berbahaya pemicu serangan jantung mendadak.',
    'category' => 'NPS',
    'definition' => 'SINTE: Tembakau gorila yang disemprot cairan kimia kanabinoid buatan beracun berkekuatan ratusan kali ganja biasa.',
  ),
  24 => 
  array (
    'word' => 'PIPET',
    'hint' => 'Pipa kaca kecil tahan api yang disalahgunakan sebagai wadah membakar kristal sabu.',
    'category' => 'Peralatan Narkoba',
    'definition' => 'PIPET: Tabung kaca silinder kecil yang digunakan oleh pengguna narkoba sabu untuk memanaskan kristal.',
  ),
  25 => 
  array (
    'word' => 'DARAH',
    'hint' => 'Cairan tubuh yang mengalirkan racun narkotika ke seluruh sel dan otak manusia.',
    'category' => 'Sistem Tubuh',
    'definition' => 'DARAH: Jalur sirkulasi utama tempat zat terlarang diserap dan disebarkan ke organ vital hanya dalam hitungan detik.',
  ),
  26 => 
  array (
    'word' => 'TELER',
    'hint' => 'Kondisi mabuk berat, linglung, dan kehilangan kesadaran setelah memakai zat.',
    'category' => 'Efek Langsung',
    'definition' => 'TELER: Keadaan penurunan respons kognitif dan motorik drastis yang membahayakan diri dan orang lain.',
  ),
  27 => 
  array (
    'word' => 'BADAN',
    'hint' => 'Fisik manusia yang kurus kering dan ringkih akibat gerogotan racun narkotika.',
    'category' => 'Dampak Fisik',
    'definition' => 'BADAN: Penurunan drastis berat badan, daya tahan tubuh, dan kebugaran akibat pola hidup perusak narkoba.',
  ),
  28 => 
  array (
    'word' => 'DOSIS',
    'hint' => 'Takaran konsumsi zat yang bila ditingkatkan terus berujung pada kematian overdosis.',
    'category' => 'Farmakologi',
    'definition' => 'DOSIS: Jumlah kuantitatif zat kimia yang dikonsumsi, yang pada pengguna narkoba selalu meningkat akibat toleransi.',
  ),
  29 => 
  array (
    'word' => 'SEBAR',
    'hint' => 'Tindak pidana mengedarkan narkoba ke berbagai lapisan masyarakat secara gelap.',
    'category' => 'Peredaran Gelap',
    'definition' => 'SEBAR: Tindakan kriminal mendistribusikan zat terlarang yang diancam hukuman berat oleh undang-undang.',
  ),
  30 => 
  array (
    'word' => 'BOGOR',
    'hint' => 'Kota lokasi Balai Besar Rehabilitasi Narkotika BNN terbesar dan terlengkap di Indonesia.',
    'category' => 'Pusat Rehab',
    'definition' => 'BOGOR: Lokasi Balai Besar Rehabilitasi BNN Lido Bogor sebagai pusat rujukan pemulihan adiksi nasional.',
  ),
  31 => 
  array (
    'word' => 'MORAL',
    'hint' => 'Benteng integritas batin dan akhlak pemuda agar kokoh menolak ajakan narkoba.',
    'category' => 'Ketahanan Diri',
    'definition' => 'MORAL: Nilai karakter dan keimanan yang menjadi perisai internal terkuat generasi muda dari bujuk rayu narkoba.',
  ),
  32 => 
  array (
    'word' => 'PULIH',
    'hint' => 'Kondisi keberhasilan pecandu lepas dari ketergantungan zat dan hidup produktif.',
    'category' => 'Pemulihan',
    'definition' => 'PULIH: Keadaan terbebas dari dorongan adiksi setelah menjalani proses terapi rehabilitasi medis dan sosial.',
  ),
  33 => 
  array (
    'word' => 'BEBAS',
    'hint' => 'Kemerdekaan sejati generasi muda yang bersih dari bayang-bayang narkotika.',
    'category' => 'P4GN',
    'definition' => 'BEBAS: Hidup tanpa ketergantungan zat berbahaya, bebas dari jerat hukum, dan merdeka meraih cita-cita.',
  ),
  34 => 
  array (
    'word' => 'KURIR',
    'hint' => 'Orang suruhan jaringan bandar yang bertugas mengantar paket narkoba terlarang.',
    'category' => 'Jaringan Gelap',
    'definition' => 'KURIR: Pelaku lapangan peredaran narkoba yang diperalat bandar dan tetap terancam pidana penjara sangat berat.',
  ),
  35 => 
  array (
    'word' => 'JARUM',
    'hint' => 'Alat suntik yang dipakai bergantian sesama pecandu pemicu utama infeksi HIV.',
    'category' => 'Risiko Penularan',
    'definition' => 'JARUM: Alat suntik suntik narkoba steril yang bila dipakai bersama menjadi vektor utama penularan virus HIV dan hepatitis.',
  ),
  36 => 
  array (
    'word' => 'HEROIN',
    'hint' => 'Narkotika semisintetik sangat adiktif turunan morfin golongan I (putaw).',
    'category' => 'Opiat Semisintetik',
    'definition' => 'HEROIN: Zat serbuk putih turunan morfin yang sangat adiktif dan menekan sistem pernapasan hingga kematian.',
  ),
  37 => 
  array (
    'word' => 'KOKAIN',
    'hint' => 'Alkaloid kristal putih dari daun tanaman koka stimulan kuat sistem saraf pusat.',
    'category' => 'Stimulan Alami',
    'definition' => 'KOKAIN: Serbuk putih dari tanaman Erythroxylum coca yang memicu euforia singkat namun merusak jantung dan pembuluh darah.',
  ),
  38 => 
  array (
    'word' => 'MORFIN',
    'hint' => 'Alkaloid candu pereda nyeri kuat yang dilarang keras disalahgunakan tanpa izin dokter.',
    'category' => 'Opiat Alami',
    'definition' => 'MORFIN: Senyawa analgetik opioid dari getah Papaver somniferum yang sangat mudah memicu ketergantungan berat.',
  ),
  39 => 
  array (
    'word' => 'ADIKSI',
    'hint' => 'Penyakit otak kronis kambuhan yang ditandai dorongan tak terkendali memakai zat.',
    'category' => 'Patologi Adiksi',
    'definition' => 'ADIKSI: Gangguan medis kronis di mana sirkuit otak dibajak sehingga pecandu terus mencari zat meski tahu risikonya.',
  ),
  40 => 
  array (
    'word' => 'RELAPS',
    'hint' => 'Kondisi kekambuhan menggunakan narkoba kembali setelah sempat bersih dalam masa pemulihan.',
    'category' => 'Siklus Adiksi',
    'definition' => 'RELAPS: Kembalinya pecandu mengonsumsi narkoba akibat terpapar pemicu stres, lingkungan lama, atau emosi negatif.',
  ),
  41 => 
  array (
    'word' => 'TOKSIK',
    'hint' => 'Sifat racun mematikan dari senyawa kimia narkotika yang merusak organ vital.',
    'category' => 'Toksisitas',
    'definition' => 'TOKSIK: Kadar racun zat adiktif yang merusak sel-sel tubuh dan berujung pada kerusakan multi-organ.',
  ),
  42 => 
  array (
    'word' => 'BANDAR',
    'hint' => 'Pelaku kejahatan pemodal dan pengendali pasokan narkotika di jaringan peredaran gelap.',
    'category' => 'Penegakan Hukum',
    'definition' => 'BANDAR: Pihak pengelola bisnis gelap narkoba yang menjadi target utama tindakan represif tegas aparat penegak hukum.',
  ),
  43 => 
  array (
    'word' => 'SUNTIK',
    'hint' => 'Cara konsumsi narkoba cair ke pembuluh darah vena berisiko fatal menularkan penyakit.',
    'category' => 'Metode Pemakaian',
    'definition' => 'SUNTIK: Jalur pemakaian narkoba melalui jarum suntik yang rentan abses, pembusukan jaringan, dan infeksi menular.',
  ),
  44 => 
  array (
    'word' => 'KEJANG',
    'hint' => 'Reaksi gangguan listrik mendadak di otak saat terjadi overdosis obat atau stimulan.',
    'category' => 'Gejala Kritis',
    'definition' => 'KEJANG: Episode kontraksi otot tak terkontrol yang dipicu oleh stimulasi berlebih atau putus obat keras mendadak.',
  ),
  45 => 
  array (
    'word' => 'TERAPI',
    'hint' => 'Rangkaian tindakan medis dan psikososial terstruktur untuk menyembuhkan pecandu.',
    'category' => 'Rehabilitasi',
    'definition' => 'TERAPI: Intervensi klinis psikologis dan medis untuk memulihkan fungsi kognitif serta perilaku mantan pecandu.',
  ),
  46 => 
  array (
    'word' => 'KONSUL',
    'hint' => 'Sesi tatap muka konseling psikologis bersama konselor adiksi untuk memetakan pemulihan.',
    'category' => 'Konseling',
    'definition' => 'KONSUL: Wawancara motivasional antara konselor adiksi dan penyalah guna guna membangun kesadaran pulih.',
  ),
  47 => 
  array (
    'word' => 'BAHAYA',
    'hint' => 'Dampak buruk nyata yang mengancam keselamatan raga, jiwa, dan masa depan manusia.',
    'category' => 'Edukasi Pencegahan',
    'definition' => 'BAHAYA: Segala bentuk ancaman kerusakan mental, hukum, fisik, dan sosial akibat mengonsumsi narkotika.',
  ),
  48 => 
  array (
    'word' => 'STIGMA',
    'hint' => 'Cap negatif masyarakat yang sering membuat pecandu takut melapor untuk direhabilitasi.',
    'category' => 'Sosial Budaya',
    'definition' => 'STIGMA: Prasangka dan diskriminasi sosial yang harus dihilangkan agar para korban narkoba mau melapor sukarela.',
  ),
  49 => 
  array (
    'word' => 'VAPING',
    'hint' => 'Aktivitas hisap uap elektrik yang kini kerap disusupi cairan narkotika berbahaya.',
    'category' => 'Modus Baru',
    'definition' => 'VAPING: Media hisap rokok elektrik yang disalahgunakan jaringan pengedar untuk menyusupkan liquid sabu atau sinte.',
  ),
  50 => 
  array (
    'word' => 'GEJALA',
    'hint' => 'Tanda-tanda perubahan fisik dan perilaku mencurigakan pada diri seorang pecandu narkoba.',
    'category' => 'Deteksi Dini',
    'definition' => 'GEJALA: Perubahan fisik seperti mata merah, berat badan turun drastis, serta perilaku tertutup dan agresif.',
  ),
  51 => 
  array (
    'word' => 'NEURON',
    'hint' => 'Sel-sel saraf otak manusia yang mengalami kerusakan permanen akibat dihantam narkotika.',
    'category' => 'Neurobiologi',
    'definition' => 'NEURON: Unit fungsional terkecil sistem saraf otak yang jalur sinapsisnya rusak terbakar zat adiktif.',
  ),
  52 => 
  array (
    'word' => 'NARKOBA',
    'hint' => 'Akronim umum resmi untuk Narkotika, Psikotropika, dan Bahan Adiktif Berbahaya.',
    'category' => 'Istilah Resmi',
    'definition' => 'NARKOBA: Istilah payung untuk seluruh zat kimia yang menurunkan kesadaran dan menimbulkan ketergantungan parah.',
  ),
  53 => 
  array (
    'word' => 'METADON',
    'hint' => 'Obat agonis opioid sintetis untuk terapi pemulihan ketergantungan putaw/heroin.',
    'category' => 'Terapi Substitusi',
    'definition' => 'METADON: Obat medis pengganti di bawah pengawasan ketat BNN untuk menghentikan sakaw pecandu opioid secara bertahap.',
  ),
  54 => 
  array (
    'word' => 'KETAMIN',
    'hint' => 'Zat anestesi hewan dan medis yang disalahgunakan sebagai halusinogen disosiatif.',
    'category' => 'Disosiatif',
    'definition' => 'KETAMIN: Zat penenang yang memicu sensasi lepas dari raga (K-hole) dan kerusakan fatal saluran kemih.',
  ),
  55 => 
  array (
    'word' => 'INHALAN',
    'hint' => 'Bahan pelarut kimia mudah menguap (seperti lem dan bensin) yang dihirup perusak otak.',
    'category' => 'Zat Inhalan',
    'definition' => 'INHALAN: Uap senyawa kimia berbahaya yang langsung mematikan jutaan sel otak dan memicu sudden sniffing death.',
  ),
  56 => 
  array (
    'word' => 'SEDATIF',
    'hint' => 'Golongan zat penenang yang memperlambat laju aktivitas otak dan sistem saraf.',
    'category' => 'Depresan',
    'definition' => 'SEDATIF: Obat penenang yang jika disalahgunakan memicu perlambatan detak jantung dan koma mendalam.',
  ),
  57 => 
  array (
    'word' => 'EKSTASI',
    'hint' => 'Tablet metamfetamin halusinogenik (MDMA) yang kerap diedarkan di tempat hiburan malam.',
    'category' => 'Stimulan-Halusinogen',
    'definition' => 'EKSTASI: MDMA dalam bentuk pil berlogo yang memicu dehidrasi ekstrem, serangan panas (heatstroke), dan gagal ginjal.',
  ),
  58 => 
  array (
    'word' => 'DOPAMIN',
    'hint' => 'Neurotransmitter rasa senang di otak yang dibajak habis-habisan oleh zat narkotika.',
    'category' => 'Neurobiologi',
    'definition' => 'DOPAMIN: Senyawa pembawa pesan kimiawi otak yang konsentrasinya dilipatgandakan paksa oleh narkoba hingga rusak.',
  ),
  59 => 
  array (
    'word' => 'ASESMEN',
    'hint' => 'Prosedur pemeriksaan menyeluruh aspek hukum dan medis bagi tersangka narkoba.',
    'category' => 'Prosedur Hukum BNN',
    'definition' => 'ASESMEN: Proses evaluasi Tim Asesmen Terpadu (TAT) BNN untuk menentukan apakah pelaku adalah pecandu atau pengedar.',
  ),
  60 => 
  array (
    'word' => 'RESIDIF',
    'hint' => 'Kecenderungan penyakit kambuhan yang sering dialami oleh mantan pecandu narkoba.',
    'category' => 'Medis Adiksi',
    'definition' => 'RESIDIF: Sifat alami penyakit adiksi yang rentan kambuh sewaktu-waktu bila mantan pecandu tidak menjaga pemulihan.',
  ),
  61 => 
  array (
    'word' => 'SKRINING',
    'hint' => 'Uji tapis cepat untuk mendeteksi keberadaan senyawa narkoba dalam tubuh seseorang.',
    'category' => 'Pemeriksaan',
    'definition' => 'SKRINING: Pengujian pendahuluan (seperti rapid test urin) untuk memastikan indikasi penggunaan zat narkotika.',
  ),
  62 => 
  array (
    'word' => 'SINAPIS',
    'hint' => 'Celah antar sel saraf di otak tempat narkotika membajak penerimaan sinyal kimiawi.',
    'category' => 'Neurobiologi',
    'definition' => 'SINAPIS: Celah sinaps di mana neurotransmitter dan molekul narkotika berinteraksi dengan reseptor sel saraf.',
  ),
  63 => 
  array (
    'word' => 'NIKOTIN',
    'hint' => 'Zat adiktif stimulan dalam daun tembakau pintu gerbang awal penyalahgunaan narkoba.',
    'category' => 'Zat Adiktif',
    'definition' => 'NIKOTIN: Senyawa alkaloid tembakau yang sangat adiktif dan melatih reseptor otak untuk mudah terjerat narkoba lain.',
  ),
  64 => 
  array (
    'word' => 'DEPRESI',
    'hint' => 'Gangguan kejiwaan berupa keputusasaan mendalam yang kerap melanda saat putus zat.',
    'category' => 'Kesehatan Jiwa',
    'definition' => 'DEPRESI: Penurunan drastis suasana hati dan semangat hidup akibat terkurasnya hormon bahagia setelah memakai narkoba.',
  ),
  65 => 
  array (
    'word' => 'DETEKSI',
    'hint' => 'Langkah pencegahan mengenali keberadaan peredaran gelap narkoba di lingkungan sekitar.',
    'category' => 'Pencegahan',
    'definition' => 'DETEKSI: Kemampuan masyarakat mengenali ciri-ciri transaksi narkoba dan perubahan perilaku pemakai secara dini.',
  ),
  66 => 
  array (
    'word' => 'RELAWAN',
    'hint' => 'Penggiat anti-narkoba dari unsur masyarakat yang aktif mengedukasi bahaya narkoba.',
    'category' => 'Partisipasi Warga',
    'definition' => 'RELAWAN: Masyarakat peduli yang dilatih BNN menjadi garda terdepan sosialisasi P4GN di desa dan kampus.',
  ),
  67 => 
  array (
    'word' => 'ISOLASI',
    'hint' => 'Kecenderungan pecandu mengurung diri dari keluarga dan lingkungan sosial positif.',
    'category' => 'Perilaku Pecandu',
    'definition' => 'ISOLASI: Menarik diri dari pergaulan sehat dan keluarga karena sibuk menyembunyikan kebiasaan buruk narkobanya.',
  ),
  68 => 
  array (
    'word' => 'SINTETIS',
    'hint' => 'Narkotika buatan laboratorium kimia non-alami dengan efek racun jauh lebih destruktif.',
    'category' => 'Jenis Narkotika',
    'definition' => 'SINTETIS: Narkoba yang diproduksi murni dari reaksi bahan kimia sintetis seperti metamfetamin dan fentanil.',
  ),
  69 => 
  array (
    'word' => 'STIMULAN',
    'hint' => 'Golongan zat yang memacu percepatan kerja sistem saraf pusat dan denyut jantung.',
    'category' => 'Kelas Farmakologi',
    'definition' => 'STIMULAN: Zat perangsang sistem saraf yang memaksa organ tubuh bekerja melampaui batas wajar hingga kolaps.',
  ),
  70 => 
  array (
    'word' => 'DEPRESAN',
    'hint' => 'Golongan zat penekan aktivitas sistem saraf pusat yang memperlambat fungsi organ vital.',
    'category' => 'Kelas Farmakologi',
    'definition' => 'DEPRESAN: Zat peredam saraf otak yang memicu rasa kantuk berat dan risiko kematian akibat henti napas saat tidur.',
  ),
  71 => 
  array (
    'word' => 'SINDROM',
    'hint' => 'Sekumpulan tanda dan gejala medis komplikasi yang menyertai kondisi putus zat.',
    'category' => 'Medis Klinis',
    'definition' => 'SINDROM: Kumpulan gejala withdrawal syndrome yang menyerang fisik dan psikis saat asupan narkotika terhenti.',
  ),
  72 => 
  array (
    'word' => 'PARANOID',
    'hint' => 'Gangguan mental ketakutan dan kecurigaan berlebihan yang dialami pecandu sabu.',
    'category' => 'Gangguan Jiwa',
    'definition' => 'PARANOID: Kondisi waham di mana pemakai merasa selalu dimata-matai, dikejar, atau hendak dicelakai orang lain.',
  ),
  73 => 
  array (
    'word' => 'RESIDUUM',
    'hint' => 'Sisa endapan metabolit racun narkotika yang tertimbun di jaringan lemak tubuh.',
    'category' => 'Metabolisme Zat',
    'definition' => 'RESIDUUM: Endapan sisa zat kimia narkoba yang tersimpan lama dalam jaringan tubuh meski sudah lama berhenti.',
  ),
  74 => 
  array (
    'word' => 'KECANDUAN',
    'hint' => 'Keadaan fisik dan mental yang terikat erat pada obat bius atau zat adiktif terlarang.',
    'category' => 'Kondisi Adiksi',
    'definition' => 'KECANDUAN: Ketidakmampuan biologis dan psikologis menghentikan konsumsi narkotika meski membawa petaka nyata.',
  ),
  75 => 
  array (
    'word' => 'PSIKOSIS',
    'hint' => 'Kondisi gangguan jiwa parah di mana penderita kehilangan kontak dengan kenyataan nyata.',
    'category' => 'Gangguan Mental',
    'definition' => 'PSIKOSIS: Gangguan jiwa berat akibat kerusakan saraf otak yang membuat pecandu berhalusinasi dan meracau.',
  ),
  76 => 
  array (
    'word' => 'SOMATIK',
    'hint' => 'Keluhan fisik nyata seperti nyeri lambung dan sendi akibat komplikasi zat adiktif.',
    'category' => 'Kesehatan Fisik',
    'definition' => 'SOMATIK: Gejala penyakit pada organ raga tubuh yang dipicu oleh kerusakan jaringan akibat endapan racun narkoba.',
  ),
  77 => 
  array (
    'word' => 'OVERDOSE',
    'hint' => 'Istilah internasional untuk kondisi konsumsi zat narkoba melampaui batas toleransi tubuh.',
    'category' => 'Kedaruratan Medis',
    'definition' => 'OVERDOSE: Kondisi kritis takaran berlebih yang mematikan pusat pernapasan otak dan memicu kematian seketika.',
  ),
  78 => 
  array (
    'word' => 'NARKOTIKA',
    'hint' => 'Zat penurun kesadaran dan penghilang nyeri yang peredaran gelapnya dilarang keras.',
    'category' => 'Regulasi Hukum',
    'definition' => 'NARKOTIKA: Zat buatan atau alami dari tanaman yang menurunkan kesadaran dan diatur ketat dalam UU No. 35/2009.',
  ),
  79 => 
  array (
    'word' => 'PREKURSOR',
    'hint' => 'Zat atau bahan kimia pemula yang digunakan untuk memproduksi olahan narkotika.',
    'category' => 'Bahan Kimia',
    'definition' => 'PREKURSOR: Senyawa kimia industri yang diawasi ketat karena dapat dialihkan untuk sintesis narkoba di lab gelap.',
  ),
  80 => 
  array (
    'word' => 'TOLERANSI',
    'hint' => 'Penurunan respons tubuh terhadap zat sehingga menuntut dosis makin tinggi untuk berefek.',
    'category' => 'Farmakodinamik',
    'definition' => 'TOLERANSI: Adaptasi sel otak yang menuntut dosis narkoba terus bertambah hingga mendekati ambang mematikan.',
  ),
  81 => 
  array (
    'word' => 'AMFETAMIN',
    'hint' => 'Kelompok zat stimulan susunan saraf pusat pembawa sifat adiksi dan insomnia tinggi.',
    'category' => 'Stimulan',
    'definition' => 'AMFETAMIN: Senyawa stimulan sintetis perangsang sistem saraf yang memicu lonjakan tekanan darah berbahaya.',
  ),
  82 => 
  array (
    'word' => 'OVERDOSIS',
    'hint' => 'Kondisi keracunan fatal akibat mengonsumsi zat narkotika melebihi takaran aman.',
    'category' => 'Kedaruratan Medis',
    'definition' => 'OVERDOSIS: Keadaan kritis di mana organ tubuh lumpuh tidak mampu menahan beban racun zat hingga berujung maut.',
  ),
  83 => 
  array (
    'word' => 'DELIRIUM',
    'hint' => 'Kondisi kebingungan mental akut dan disorientasi hebat akibat racun narkotika.',
    'category' => 'Gangguan Kognitif',
    'definition' => 'DELIRIUM: Gangguan kesadaran mendadak di mana penderita mengigau hebat dan tidak mengenali lingkungan sekitar.',
  ),
  84 => 
  array (
    'word' => 'NEURONAL',
    'hint' => 'Jaringan saraf pembentuk sistem komunikasi otak yang dihancurkan oleh zat adiktif.',
    'category' => 'Sistem Saraf',
    'definition' => 'NEURONAL: Jaringan miliaran sel neuron di otak yang rusak sehingga mengacaukan fungsi nalar dan memori.',
  ),
  85 => 
  array (
    'word' => 'RESIDIVIS',
    'hint' => 'Pelaku kejahatan tindak pidana narkoba yang mengulangi perbuatannya setelah dihukum.',
    'category' => 'Hukum Pidana',
    'definition' => 'RESIDIVIS: Pelaku kejahatan narkotika yang kembali terjerat kasus serupa karena belum lepas dari pengaruh sindikat.',
  ),
  86 => 
  array (
    'word' => 'KONSULTAN',
    'hint' => 'Tenaga ahli profesional yang mendampingi proses terapi pemulihan adiksi pecandu.',
    'category' => 'Tenaga Medis',
    'definition' => 'KONSULTAN: Praktisi medis atau konselor adiksi bersertifikasi yang merancang program pemulihan pasien narkoba.',
  ),
  87 => 
  array (
    'word' => 'PENANGKAL',
    'hint' => 'Zat obat darurat seperti nalokson yang membalikkan efek mematikan overdosis opiat.',
    'category' => 'Medis Darurat',
    'definition' => 'PENANGKAL: Antidot medis penyelamat nyawa darurat yang mampu menetralisir efek penekanan napas dari narkotika.',
  ),
  88 => 
  array (
    'word' => 'HALUSINASI',
    'hint' => 'Gangguan persepsi palsu melihat atau mendengar sesuatu yang sesungguhnya tidak nyata.',
    'category' => 'Gejala Jiwa',
    'definition' => 'HALUSINASI: Persepsi semu panca indera tanpa adanya stimulus fisik nyata akibat keracunan zat halusinogen.',
  ),
  89 => 
  array (
    'word' => 'KETAGIHAN',
    'hint' => 'Kondisi dorongan psikologis yang luar biasa kuat untuk selalu mengonsumsi zat kembali.',
    'category' => 'Psikologi Adiksi',
    'definition' => 'KETAGIHAN: Hasrat emosional kompulsif mencari dan memakai narkoba yang menenggelamkan logika nalar sehat.',
  ),
  90 => 
  array (
    'word' => 'REPRESIF',
    'hint' => 'Tindakan penegakan hukum dan pemberantasan tegas aparat terhadap bandar narkotika.',
    'category' => 'Penegakan Hukum',
    'definition' => 'REPRESIF: Strategi penindakan hukum tegas tanpa pandang bulu untuk memutus mata rantai pasokan sindikat narkoba.',
  ),
  91 => 
  array (
    'word' => 'PREVENTIF',
    'hint' => 'Upaya pencegahan dini membentengi masyarakat sebelum tersentuh oleh narkotika.',
    'category' => 'Pencegahan P4GN',
    'definition' => 'PREVENTIF: Langkah sosialisasi, advokasi, dan edukasi sistematis agar generasi muda imun dari bujukan narkoba.',
  ),
  92 => 
  array (
    'word' => 'BIOKIMIA',
    'hint' => 'Proses reaksi kimiawi dalam tubuh manusia yang dirusak dan diubah oleh narkotika.',
    'category' => 'Sains Medis',
    'definition' => 'BIOKIMIA: Keseimbangan hormon dan neurotransmitter tubuh yang hancur berantakan akibat racun zat adiktif.',
  ),
  93 => 
  array (
    'word' => 'KESADARAN',
    'hint' => 'Fungsi luhur otak yang hilang terbius saat seseorang berada di bawah pengaruh narkoba.',
    'category' => 'Fungsi Otak',
    'definition' => 'KESADARAN: Kejernihan akal budi dan kontrol diri yang terenggut seketika saat zat psikoaktif meracuni otak.',
  ),
  94 => 
  array (
    'word' => 'DETOKSIKAS',
    'hint' => 'Prosedur medis pengeluaran racun narkoba dari tubuh pasien di fasilitas rehabilitasi.',
    'category' => 'Tahapan Rehab',
    'definition' => 'DETOKSIKAS: Tahapan awal rehabilitasi medis untuk membersihkan sisa racun narkotika dari peredaran darah.',
  ),
  95 => 
  array (
    'word' => 'HALUSINOGEN',
    'hint' => 'Golongan zat psikoaktif pemicu khayalan visual palsu dan kekacauan persepsi realitas.',
    'category' => 'Kelas Farmakologi',
    'definition' => 'HALUSINOGEN: Narkotika yang mengubah fungsi persepsi sensori panca indera sehingga melihat dunia semu yang mengerikan.',
  ),
  96 => 
  array (
    'word' => 'PENYALAHGUNA',
    'hint' => 'Korban yang mengonsumsi narkotika tanpa hak dan tanpa pengawasan dokter berhak direhab.',
    'category' => 'Subjek Hukum',
    'definition' => 'PENYALAHGUNA: Korban ketergantungan yang berdasarkan UU No. 35/2009 wajib menjalani rehabilitasi medis dan sosial.',
  ),
  97 => 
  array (
    'word' => 'DETOKSIKASI',
    'hint' => 'Proses pelepasan dan netralisasi racun narkoba dari organ tubuh di bawah pantauan dokter.',
    'category' => 'Terapi Medis',
    'definition' => 'DETOKSIKASI: Perawatan medis terpadu untuk menetralkan racun zat adiktif dalam tubuh dan meredakan siksaan sakaw.',
  ),
  98 => 
  array (
    'word' => 'NEUROTOKSIK',
    'hint' => 'Sifat bahan kimia beracun yang merusak jaringan dan mematikan fungsi sel saraf otak.',
    'category' => 'Toksisitas Saraf',
    'definition' => 'NEUROTOKSIK: Dampak destruktif zat narkoba yang membunuh sel neuron otak secara masif dan tidak dapat diganti.',
  ),
  99 => 
  array (
    'word' => 'PREVENSIONAL',
    'hint' => 'Pendekatan sistematis berbasis ketahanan keluarga dan lingkungan demi pencegahan narkoba.',
    'category' => 'Strategi P4GN',
    'definition' => 'PREVENSIONAL: Kebijakan berorientasi pencegahan menyeluruh demi mewujudkan lingkungan masyarakat yang bersih dari narkoba.',
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
