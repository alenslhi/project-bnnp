<?php

namespace Database\Seeders;

use App\Models\GameMitosFakta;
use Illuminate\Database\Seeder;

class GameMitosFaktaSeeder extends Seeder
{
    public function run(): void
    {
        GameMitosFakta::truncate();

        $questions = array (
  0 => 
  array (
    'statement' => 'Mencoba narkoba jenis sabu atau sintetis hanya sekali tidak berisiko memicu ketergantungan.',
    'is_fakta' => false,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'Zat adiktif modern membanjiri dopamin otak hingga 10 kali lipat ambang alami. Lonjakan ekstrem ini langsung membajak sirkuit penghargaan otak sejak pemakaian pertama dan memicu rasa candu yang kuat.',
    'clue' => 'Lonjakan dopamin artifisial merangsang otak untuk terus mencari zat pemicu rasa CANDU.',
  ),
  1 => 
  array (
    'statement' => 'Kecanduan narkoba adalah penyakit otak kronis kambuhan (Chronic Relapsing Brain Disease), bukan sekadar kelemahan moral.',
    'is_fakta' => true,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'WHO dan dunia medis menetapkan adiksi sebagai gangguan neurobiologis di mana struktur dan fungsi sel saraf otak mengalami perubahan biologis permanen yang membutuhkan terapi medis terpadu.',
    'clue' => 'Pemulihan penyakit otak ini memerlukan penanganan terstruktur melalui program REHAB.',
  ),
  2 => 
  array (
    'statement' => 'Toleransi zat membuat pemakai narkoba harus terus meningkatkan dosis agar mendapatkan efek rasa senang yang sama.',
    'is_fakta' => true,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'Karena reseptor sel saraf otak mengalami kejenuhan dan penurunan sensitivitas, pemakai terpaksa menaikkan takaran konsumsi zat hingga mendekati ambang mematikan overdosis.',
    'clue' => 'Mekanisme biologis penurunan respons otak terhadap zat dikenal dengan istilah TOLERANSI.',
  ),
  3 => 
  array (
    'statement' => 'Otak manusia dapat sembuh dan kembali normal seketika setelah berhenti memakai narkoba tanpa perlu proses detoksifikasi.',
    'is_fakta' => false,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'Pemulihan jalur sinapsis dan keseimbangan neurotransmitter otak membutuhkan waktu berbulan-bulan hingga bertahun-tahun serta pendampingan medis pengeluaran racun yang intensif.',
    'clue' => 'Tahapan awal pelepasan racun kimia dari dalam organ tubuh disebut DETOKSIKASI.',
  ),
  4 => 
  array (
    'statement' => 'Dopamin alami yang dipicu oleh olahraga dan pencapaian prestasi jauh lebih stabil dan tidak merusak sel neuron otak.',
    'is_fakta' => true,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'Hormon endorfin dan dopamin yang dihasilkan dari aktivitas fisik bekerja secara alami dan harmonis dengan sistem saraf tanpa merusak reseptor otak seperti yang dilakukan zat terlarang.',
    'clue' => 'Hormon alami ini membuat tubuh bugar, pikiran positif, dan hidup tetap SEHAT.',
  ),
  5 => 
  array (
    'statement' => 'Pecandu narkoba bisa sembuh total hanya dengan mengurung diri di kamar mandi selama 3 hari tanpa obat pendamping.',
    'is_fakta' => false,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'Menghentikan narkoba mendadak (cold turkey) tanpa pengawasan dokter berisiko tinggi memicu kejang, henti napas, delirium, hingga kematian mendadak akibat syok sistem saraf otonom.',
    'clue' => 'Rasa sakit ekstrem, menggigil, dan kejang saat tubuh kehabisan zat adiktif disebut SAKAW.',
  ),
  6 => 
  array (
    'statement' => 'Zat adiktif merusak bagian prefrontal cortex otak yang bertanggung jawab atas nalar sehat dan pengambilan keputusan.',
    'is_fakta' => true,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'Kerusakan pada korteks prefrontal membuat pengguna kehilangan kontrol diri rasional, menjadi impulsif, dan nekat melakukan tindak kriminalitas demi mendapatkan narkoba.',
    'clue' => 'Organ vital pengendali memori, logika, dan emosi yang dirusak oleh narkotika adalah OTAK.',
  ),
  7 => 
  array (
    'statement' => 'Kekambuhan (relaps) pada mantan pecandu narkoba membuktikan bahwa proses rehabilitasi telah gagal selamanya.',
    'is_fakta' => false,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'Sebagai penyakit kronis kambuhan, relaps adalah sinyal bahwa rencana pemulihan perlu dievaluasi kembali. Dengan konseling berkelanjutan dan dukungan keluarga, mantan pecandu tetap bisa pulih produktif.',
    'clue' => 'Kondisi kembalinya dorongan memakai narkoba saat masa pemulihan dikenal sebagai RELAPS.',
  ),
  8 => 
  array (
    'statement' => 'Otak remaja yang berusia di bawah 21 tahun jauh lebih rentan mengalami kerusakan permanen akibat narkotika dibanding orang dewasa.',
    'is_fakta' => true,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'Otak manusia terus berkembang hingga usia 25 tahun. Masuknya zat psikoaktif pada masa remaja merusak pembentukan jalur sinapsis permanen sehingga kecerdasan dan emosi terganggu seumur hidup.',
    'clue' => 'Unit sel fungsional terkecil di otak yang rusak permanen oleh racun narkoba adalah NEURON.',
  ),
  9 => 
  array (
    'statement' => 'Ketergantungan psikologis pada narkoba jauh lebih sulit dipulihkan dibandingkan ketergantungan fisik semata.',
    'is_fakta' => true,
    'badge' => 'Adiksi & Biologi Otak',
    'explanation' => 'Gejala fisik sakaw dapat dinetralisir dalam hitungan hari, namun sugesti psikologis dan memori euforia semu yang tersimpan di memori otak bawah sadar membutuhkan terapi perilaku kognitif jangka panjang.',
    'clue' => 'Kondisi ikatan mental kronis yang membuat seseorang terjajah oleh zat terlarang disebut ADIKSI.',
  ),
  10 => 
  array (
    'statement' => 'Sabu aman digunakan sebagai suplemen penambah stamina bagi pekerja lembur dan supir jarak jauh.',
    'is_fakta' => false,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Sabu bukan penambah energi, melainkan stimulan destruktif yang memeras cadangan daya tubuh secara paksa. Efeknya adalah gagal jantung, stroke panas, dan kerusakan sel neuron permanen.',
    'clue' => 'Zat kristal putih stimulan keras perusak susunan saraf pusat ini populer disebut SABU.',
  ),
  11 => 
  array (
    'statement' => 'Meminum susu kental manis atau air kelapa hijau setelah memakai sabu dapat menghilangkan efek racun di tubuh.',
    'is_fakta' => false,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Zat metamfetamin diserap ke dalam aliran darah dan jaringan otak dalam hitungan detik. Susu atau air kelapa hanya masuk ke lambung dan sama sekali tidak bisa menetralkan racun narkotika.',
    'clue' => 'Zat berbahaya dalam metamfetamin yang merusak organ tubuh secara sistemik adalah RACUN.',
  ),
  12 => 
  array (
    'statement' => 'Penggunaan sabu jangka panjang dapat menyebabkan kondisi gigi rapuh, menghitam, dan tanggal yang disebut meth mouth.',
    'is_fakta' => true,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Zat kimia sabu mengeringkan kelenjar air liur, memicu kebiasaan menggertakkan gigi (bruxism), dan mengikis enamel gigi secara agresif hingga hancur membusuk.',
    'clue' => 'Penurunan daya tahan dan kerusakan fisik menyeluruh membuat ringkih seluruh raga dan BADAN.',
  ),
  13 => 
  array (
    'statement' => 'Pemakai sabu sering mengalami halusinasi serangga merayap di bawah kulit mereka (formication).',
    'is_fakta' => true,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Halusinasi taktil ini membuat pemakai sabu menggaruk-garuk kulitnya secara histeris hingga terluka parah dan bernanah karena mengira ada jutaan kutu sabu di tubuh mereka.',
    'clue' => 'Gangguan persepsi semu melihat atau merasakan hal yang tidak nyata disebut HALUSINASI.',
  ),
  14 => 
  array (
    'statement' => 'Sabu efektif dan aman digunakan sebagai metode diet cepat untuk menurunkan berat badan remaja putri.',
    'is_fakta' => false,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Penurunan berat badan akibat sabu terjadi karena rusaknya pusat nafsu makan di hipotalamus, malnutrisi akut, dan gagal organ. Ini bukan diet sehat, melainkan tanda sekarat tubuh.',
    'clue' => 'Menjaga berat badan ideal seharusnya dilakukan dengan pola olahraga dan hidup SEHAT.',
  ),
  15 => 
  array (
    'statement' => 'Pengguna sabu rentan mengalami gangguan kejiwaan paranoid ekstrem di mana mereka merasa selalu diawasi dan dikejar.',
    'is_fakta' => true,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Kelebihan dopamin kronis di sistem limbik memicu psikosis sabu, waham kejar, kecurigaan berlebihan pada keluarga, hingga tindakan kekerasan akibat ketakutan tak berdasar.',
    'clue' => 'Kondisi gangguan jiwa rasa curiga dan ketakutan berlebihan ini dikenal dengan istilah PARANOID.',
  ),
  16 => 
  array (
    'statement' => 'Menghisap sabu lewat pipa kaca (pipet) tidak menimbulkan ketergantungan seberat menyuntikkannya ke pembuluh darah.',
    'is_fakta' => false,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Menghisap uap sabu langsung membawanya ke paru-paru dan mencapai otak hanya dalam 7-10 detik. Daya rusaknya terhadap otak dan tingkat adiktifnya sama mematikannya dengan jalur suntik.',
    'clue' => 'Pipa kaca silinder kecil yang sering dipakai membakar kristal metamfetamin adalah PIPET.',
  ),
  17 => 
  array (
    'statement' => 'Metamfetamin (sabu) termasuk dalam golongan stimulan susunan saraf pusat.',
    'is_fakta' => true,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Sebagai stimulan kuat, metamfetamin memaksa pelepasan dopamin, noradrenalin, dan serotonin dalam jumlah luar biasa besar yang memacu kerja jantung melampaui batas aman.',
    'clue' => 'Golongan zat yang memacu percepatan aktivitas sistem saraf dan denyut nadi disebut STIMULAN.',
  ),
  18 => 
  array (
    'statement' => 'Efek euforia semu dari sabu yang mereda akan langsung digantikan oleh fase crash berupa rasa lelah ekstrem dan depresi berat.',
    'is_fakta' => true,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Saat pasokan sabu habis, cadangan neurotransmitter otak telah terkuras habis, menyebabkan penderita mengalami keputusasaan mendalam dan risiko tinggi melakukan bunuh diri.',
    'clue' => 'Gangguan kejiwaan berupa kemurungan mendalam dan hilangnya semangat hidup disebut DEPRESI.',
  ),
  19 => 
  array (
    'statement' => 'Bong rakitan dari botol air mineral mampu menyaring seluruh racun metamfetamin sehingga aman dihirup paru-paru.',
    'is_fakta' => false,
    'badge' => 'Mitos Sabu & Metamfetamin',
    'explanation' => 'Air dalam botol hanya mendinginkan suhu asap, bukan menyaring racun kimia. Seluruh molekul metamfetamin dan senyawa toksiknya tetap masuk 100% merusak paru-paru dan sel otak.',
    'clue' => 'Perangkat alat hisap air rakitan yang digunakan oleh penghisap kristal sabu disebut BONG.',
  ),
  20 => 
  array (
    'statement' => 'Ganja adalah tanaman alami herbal sehingga dijamin 100% aman dan tidak menimbulkan kecanduan.',
    'is_fakta' => false,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'Ganja mengandung senyawa psikoaktif THC (Tetrahidrokanabinol) yang mengikat reseptor kanabinoid otak. Penggunaan teratur menyebabkan Cannabis Use Disorder, ketergantungan, dan sindrom amotivasi.',
    'clue' => 'Senyawa psikoaktif utama dalam tanaman ganja pemicu sensasi euforia semu adalah THC.',
  ),
  21 => 
  array (
    'statement' => 'Di Indonesia, tanaman ganja (Cannabis) diklasifikasikan secara tegas sebagai Narkotika Golongan I.',
    'is_fakta' => true,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'Berdasarkan UU No. 35 Tahun 2009 tentang Narkotika, ganja tergolong narkotika golongan I yang dilarang keras diproduksi, diedarkan, maupun dikonsumsi untuk tujuan rekreasi.',
    'clue' => 'Nama tanaman herba terlarang golongan I pembawa kandungan THC adalah GANJA.',
  ),
  22 => 
  array (
    'statement' => 'Tembakau sintetis (sinte/gorila) terbuat dari daun herbal alami yang difermentasi aman tanpa bahan kimia.',
    'is_fakta' => false,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'Tembakau gorila hanyalah daun biasa yang disemprot cairan kimia sintetis (synthetic cannabinoids) berbahaya buatan laboratorium gelap dengan efek racun hingga ratusan kali lebih kuat dari ganja.',
    'clue' => 'Zat semprotan berbahaya pemicu kejang dan serangan jantung mendadak ini disebut SINTE.',
  ),
  23 => 
  array (
    'statement' => 'Penggunaan ganja pada usia remaja dapat menurunkan IQ verbal dan daya ingat secara permanen.',
    'is_fakta' => true,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'Riset neurosains membuktikan bahwa paparan THC pada otak remaja yang sedang berkembang menghambat pembentukan hippocampus, memicu penurunan kecerdasan intelektual hingga 8 poin.',
    'clue' => 'Kerusakan fungsi memori dan daya nalar terjadi langsung pada organ pengendali yaitu OTAK.',
  ),
  24 => 
  array (
    'statement' => 'Mengonsumsi tembakau sintetis dapat memicu henti napas, gagal ginjal akut, dan kejang parah sejak hisapan pertama.',
    'is_fakta' => true,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'Bahan kimia kanabinoid sintetis adalah zat beracun murni tanpa takaran aman. Banyak korban pemuda dilarikan ke IGD dalam kondisi koma dan kejang hebat akibat keracunan sinte.',
    'clue' => 'Reaksi kontraksi otot dan gangguan listrik otak mendadak akibat keracunan zat disebut KEJANG.',
  ),
  25 => 
  array (
    'statement' => 'Ganja tidak mempengaruhi kemampuan refleks mengemudi di jalan raya.',
    'is_fakta' => false,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'Ganja memperlambat waktu reaksi motorik, mengacaukan persepsi jarak dan kecepatan, serta menurunkan konsentrasi, menjadikannya salah satu pemicu utama kecelakaan lalu lintas fatal.',
    'clue' => 'Kondisi mabuk berat, linglung, dan hilangnya koordinasi fisik dikenal sebagai TELER.',
  ),
  26 => 
  array (
    'statement' => 'Narkotika jenis kanabinoid sintetis digolongkan sebagai New Psychoactive Substances (NPS).',
    'is_fakta' => true,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'NPS adalah zat psikoaktif baru yang terus dimodifikasi struktur kimianya oleh sindikat gelap narkoba untuk menghindari deteksi hukum, namun memiliki daya rusak organ yang jauh lebih ganas.',
    'clue' => 'Narkoba yang diracik murni dari reaksi bahan kimia laboratorium disebut zat SINTETIS.',
  ),
  27 => 
  array (
    'statement' => 'Ganja medis dilegalkan untuk diperjualbelikan secara bebas di apotek Indonesia tanpa izin khusus.',
    'is_fakta' => false,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'Hukum positif Indonesia tidak melegalkan peredaran bebas ganja. Seluruh pemanfaatan narkotika golongan I untuk penelitian diawasi sangat ketat oleh Kemenkes dan BNN sesuai regulasi.',
    'clue' => 'Aturan perundang-undangan nasional melarang keras tindak kejahatan mengedarkan atau SEBAR.',
  ),
  28 => 
  array (
    'statement' => 'Pemakaian ganja dapat memicu timbulnya episode psikosis akut dan skizofrenia bagi orang yang memiliki bakat genetik.',
    'is_fakta' => true,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'Studi psikiatri internasional menegaskan bahwa kandungan THC berkadar tinggi menjadi pemicu utama munculnya gangguan waham dan skizofrenia permanen pada individu rentan.',
    'clue' => 'Kondisi gangguan jiwa berat di mana penderita kehilangan kontak dengan realitas disebut PSIKOSIS.',
  ),
  29 => 
  array (
    'statement' => 'Minyak vape (liquid vape) yang beredar di pasaran tidak mungkin disusupi oleh narkotika sintetis.',
    'is_fakta' => false,
    'badge' => 'Ganja & Narkotika Sintetis',
    'explanation' => 'BNN berulang kali mengungkap laboratorium gelap yang memproduksi cairan vape berisi sabu cair, ketamin, dan kanabinoid sintetis (liquid sinte) untuk mengelabui aparat dan remaja.',
    'clue' => 'Aktivitas hisap rokok elektrik yang kerap dijadikan modus kamuflase narkoba disebut VAPING.',
  ),
  30 => 
  array (
    'statement' => 'Heroin (putaw) adalah narkotika golongan opiat yang bekerja memperlambat dan menekan sistem pernapasan.',
    'is_fakta' => true,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Heroin menekan pusat kendali napas di batang otak. Kematian akibat overdosis heroin terjadi karena korban berhenti bernapas saat tertidur pulas tanpa disadarinya.',
    'clue' => 'Narkotika serbuk putih semisintetik turunan morfin yang sangat adiktif adalah HEROIN.',
  ),
  31 => 
  array (
    'statement' => 'Pecandu heroin yang mengalami overdosis akan tertolong dengan disiram air dingin atau dipukul wajahnya.',
    'is_fakta' => false,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Menyiram air atau menampar tidak akan membalikkan penekanan napas di otak. Korban overdosis opiat membutuhkan pertolongan medis darurat segera berupa obat penawar nalokson dan oksigen.',
    'clue' => 'Kondisi konsumsi zat melebihi takaran fatal yang mematikan pusat pernapasan disebut OVERDOSIS.',
  ),
  32 => 
  array (
    'statement' => 'Nalokson adalah obat antidot darurat yang mampu membalikkan efek mematikan henti napas akibat overdosis opiat.',
    'is_fakta' => true,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Nalokson bekerja cepat mendepak molekul opiat dari reseptor di otak, mengembalikan refleks pernapasan spontan korban dalam hitungan menit sebelum otak mengalami kematian sel akibat hipoksia.',
    'clue' => 'Obat darurat penyelamat nyawa yang berfungsi menetralisir efek overdosis opiat adalah PENANGKAL.',
  ),
  33 => 
  array (
    'statement' => 'Morfin adalah obat pereda nyeri berat dari getah opium yang hanya boleh diberikan di bawah resep ketat dokter.',
    'is_fakta' => true,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Morfin memiliki fungsi medis penting untuk mengatasi nyeri kanker stadium akhir atau pasca-operasi besar, namun penyalahgunaannya di luar indikasi medis merupakan tindak pidana berbahaya.',
    'clue' => 'Alkaloid analgetik dari getah candu yang diawasi ketat peredarannya adalah MORFIN.',
  ),
  34 => 
  array (
    'statement' => 'Penyalahgunaan narkoba jenis suntik (penasun) menjadi salah satu pintu masuk utama penularan virus HIV dan Hepatitis C.',
    'is_fakta' => true,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Penggunaan jarum suntik secara bergantian sesama pemakai menyebabkan darah yang mengandung virus mematikan langsung berpindah ke pembuluh vena tanpa ada penyaring sama sekali.',
    'clue' => 'Alat suntik kotor yang dipakai bersama sebagai vektor penularan virus mematikan adalah JARUM.',
  ),
  35 => 
  array (
    'statement' => 'Seseorang yang pernah mengalami overdosis narkoba sekali dijamin kebal dan tidak akan terkena overdosis lagi.',
    'is_fakta' => false,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Pernah selamat dari overdosis tidak memberikan kekebalan biologis. Justru setelah masa jeda atau relaps, tubuh kehilangan toleransinya sehingga dosis biasa bisa langsung berakibat fatal.',
    'clue' => 'Kematian tragis yang selalu mengintai di ujung jarum suntik narkotika adalah MAUT.',
  ),
  36 => 
  array (
    'statement' => 'Getah tanaman Papaver somniferum adalah bahan baku alami pembuatan candu dan opium.',
    'is_fakta' => true,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Getah kental dari buah Papaver somniferum telah lama dikenal sebagai bahan baku narkotika golongan opiat alami yang mengawali sejarah panjang peredaran gelap narkoba dunia.',
    'clue' => 'Getah mentah bersejarah bahan pembuat morfin dan heroin ini disebut OPIUM.',
  ),
  37 => 
  array (
    'statement' => 'Terapi Rumatan Metadon (PTRM) adalah program medis resmi BNN untuk membantu pemulihan pecandu opiat secara bertahap.',
    'is_fakta' => true,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Metadon adalah cairan obat agonis opiat sintetis berdaya kerja panjang yang diminum untuk menghentikan sakaw tanpa menimbulkan sensasi melayang, sehingga pasien bisa kembali bekerja normal.',
    'clue' => 'Obat substitusi medis resmi pengontrol kecanduan opiat di bawah pengawasan BNN adalah METADON.',
  ),
  38 => 
  array (
    'statement' => 'Menyuntikkan narkoba ke pembuluh darah vena secara terus menerus dapat menyebabkan pembuluh darah mengeras dan kolaps.',
    'is_fakta' => true,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Tusukan jarum berulang memicu radang, pembentukan jaringan parut fibrotik, abses bernanah, dan infeksi bakteri endokarditis pada katup jantung yang mengancam nyawa.',
    'clue' => 'Pembuluh darah vena yang mengeras dan rusak akibat suntikan narkoba adalah URAT.',
  ),
  39 => 
  array (
    'statement' => 'Kombinasi obat penenang (benzodiazepin) bersama alkohol dan opiat sangat aman karena saling menetralkan efeknya.',
    'is_fakta' => false,
    'badge' => 'Opiat & Bahaya Overdosis',
    'explanation' => 'Kombinasi ini bersifat mematikan karena efek sinergis depresan yang melumpuhkan pusat pernapasan di otak secara ganda, memicu koma dan henti napas hanya dalam hitungan menit.',
    'clue' => 'Kondisi penurunan kesadaran stadium akhir di mana pasien tidak merespons rangsang disebut KOMA.',
  ),
  40 => 
  array (
    'statement' => 'Menghirup uap lem perekat (ngelem) tidak berbahaya bagi anak-anak karena bukan termasuk narkotika suntik.',
    'is_fakta' => false,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'Zat pelarut kimia pada lem (toluena) sangat neurotoksik. Uap yang dihirup langsung membunuh jutaan sel otak dan dapat memicu Sudden Sniffing Death Syndrome (kematian mendadak akibat henti jantung).',
    'clue' => 'Zat kimia pelarut mudah menguap yang dihirup dan merusak sel-sel otak secara fatal disebut INHALAN.',
  ),
  41 => 
  array (
    'statement' => 'Obat pereda nyeri tramadol termasuk golongan obat keras yang dilarang keras diperjualbelikan tanpa resep dokter.',
    'is_fakta' => true,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'Penyalahgunaan tramadol di luar indikasi medis dapat memicu kecanduan berat, kejang-kejang parah, halusinasi, dan kerusakan permanen pada fungsi ginjal serta hati.',
    'clue' => 'Sediaan kimia medis yang bila disalahgunakan tanpa resep menjadi racun mematikan adalah OBAT.',
  ),
  42 => 
  array (
    'statement' => 'Ketamin awalnya dikembangkan sebagai obat bius anestesi medis, namun kerap disalahgunakan sebagai zat halusinogen.',
    'is_fakta' => true,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'Penyalahgunaan ketamin memicu sensasi disosiatif mengerikan seolah jiwa terlepas dari raga (K-hole), merusak kantung kemih secara permanen, dan memicu gagal ginjal.',
    'clue' => 'Zat anestesi disosiatif yang disalahgunakan di tempat hiburan malam adalah KETAMIN.',
  ),
  43 => 
  array (
    'statement' => 'Obat batuk yang mengandung dekstrometorfan aman dikonsumsi hingga puluhan sachet sekaligus untuk mencari sensasi mabuk.',
    'is_fakta' => false,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'Mengonsumsi dekstrometorfan dalam dosis berlebih memicu keracunan akut, halusinasi menakutkan, kerusakan hati, hingga aritmia jantung yang berakibat pada kematian.',
    'clue' => 'Bentuk sediaan tablet padat obat terlarang yang kerap diedarkan secara gelap adalah PIL.',
  ),
  44 => 
  array (
    'statement' => 'Ekstasi (MDMA) adalah narkotika yang memicu dehidrasi parah dan lonjakan suhu tubuh mematikan (hyperthermia).',
    'is_fakta' => true,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'MDMA merusak termoregulasi tubuh di hipotalamus. Ditambah aktivitas berdisko berjam-jam, suhu tubuh pemakai melonjak drastis hingga organ dalam tubuh mengalami kegagalan dan rusak.',
    'clue' => 'Tablet stimulan halusinogenik populer berlogo yang diedarkan di pesta hiburan adalah EKSTASI.',
  ),
  45 => 
  array (
    'statement' => 'LSD adalah zat halusinogen dahsyat yang efek perjalanannya (tripping) dapat berlangsung hingga 12 jam lamanya.',
    'is_fakta' => true,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'Asam lisergat dietilamida (LSD) mengacaukan reseptor serotonin otak, memicu bad trip menakutkan, kepanikan histeris, hingga dorongan melompat dari gedung tinggi karena halusinasi bisa terbang.',
    'clue' => 'Zat halusinogenik kuat yang diedarkan dalam bentuk kertas perangko hisap berlogo adalah LSD.',
  ),
  46 => 
  array (
    'statement' => 'Golongan obat sedatif-hipnotik (obat penenang) tidak akan menyebabkan kecanduan jika diminum setiap malam.',
    'is_fakta' => false,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'Obat penenang seperti diazepam atau alprazolam memicu ketergantungan fisik dan psikologis cepat. Menghentikan konsumsinya secara mendadak memicu insomnia parah, kejang, dan kecemasan ekstrem.',
    'clue' => 'Golongan obat penenang penekan sistem saraf pusat yang kerap disalahgunakan adalah SEDATIF.',
  ),
  47 => 
  array (
    'statement' => 'Prekursor adalah bahan kimia pemula yang diawasi ketat karena dapat digunakan dalam proses pembuatan narkotika.',
    'is_fakta' => true,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'Pemerintah dan BNN mengontrol ketat impor serta peredaran bahan kimia prekursor seperti efedrin dan pseudoefedrin agar tidak dialihkan ke laboratorium gelap sintesis narkoba.',
    'clue' => 'Zat bahan baku pemula pembuatan olahan narkotika diatur dalam regulasi sebagai PREKURSOR.',
  ),
  48 => 
  array (
    'statement' => 'Efek kerusakan otak akibat menghirup uap lem (inhalan) dapat pulih sempurna hanya dengan meminum vitamin C.',
    'is_fakta' => false,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'Senyawa hidrokarbon pelarut pada lem melarutkan lapisan mielin lemak pelindung sel saraf otak. Kerusakan sel saraf ini bersifat permanen dan tidak dapat diperbaiki oleh vitamin biasa.',
    'clue' => 'Bahan kimia perusak otak yang memicu sindrom ketergantungan kronis disebut ZAT.',
  ),
  49 => 
  array (
    'statement' => 'Kokain adalah senyawa alkaloid stimulan kuat yang diekstraksi dari daun tanaman koka.',
    'is_fakta' => true,
    'badge' => 'Obat Keras & Inhalan',
    'explanation' => 'Kokain memicu penyempitan pembuluh darah mendadak (vasokonstriksi), lonjakan tekanan darah tinggi, serta risiko serangan jantung akut bahkan pada pengguna usia muda.',
    'clue' => 'Serbuk putih stimulan dari daun tanaman koka yang memicu ketergantungan tinggi adalah KOKAIN.',
  ),
  50 => 
  array (
    'statement' => 'Pecandu narkoba yang melapor sukarela ke BNN atau IPWL untuk rehabilitasi akan langsung ditangkap dan dipenjara.',
    'is_fakta' => false,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'Pasal 54 dan 55 UU No. 35 Tahun 2009 menjamin bahwa korban penyalahgunaan yang melapor sukarela berhak mendapatkan rehabilitasi medis dan sosial tanpa dituntut pidana sama sekali.',
    'clue' => 'Layanan perawatan resmi tanpa ancaman jeruji besi bagi pelapor sukarela adalah REHAB.',
  ),
  51 => 
  array (
    'statement' => 'Pengedar dan bandar narkoba dapat dikenai hukuman pidana mati berdasarkan undang-undang narkotika Indonesia.',
    'is_fakta' => true,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'UU No. 35 Tahun 2009 Pasal 114 memberikan sanksi maksimal hukuman mati bagi pelaku peredaran gelap narkotika dalam jumlah besar karena kejahatannya tergolong kejahatan luar biasa (extraordinary crime).',
    'clue' => 'Pihak pengelola modal dan pengendali peredaran gelap narkoba di masyarakat adalah BANDAR.',
  ),
  52 => 
  array (
    'statement' => 'Orang tua yang mengetahui anaknya kecanduan narkoba namun sengaja tidak melapor ke institusi resmi dapat dipidana.',
    'is_fakta' => true,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'Berdasarkan Pasal 128 UU Narkotika, orang tua atau wali dari pecandu yang belum cukup umur yang sengaja tidak melaporkan anaknya dapat dipidana kurungan paling lama 6 bulan atau denda.',
    'clue' => 'Menyelamatkan masa depan anak dari ancaman jeratan hukum membutuhkan keterbukaan dan MORAL.',
  ),
  53 => 
  array (
    'statement' => 'Hasil tes urin positif narkoba saja sudah cukup untuk langsung memenjarakan seseorang tanpa hak menjalani asesmen.',
    'is_fakta' => false,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'Melalui Surat Edaran Mahkamah Agung dan pedoman terpadu, tersangka yang terbukti hanya sebagai pemakai dan bukan bagian jaringan pengedar berhak menjalani asesmen terpadu untuk opsi rehabilitasi.',
    'clue' => 'Prosedur evaluasi komprehensif hukum dan medis oleh tim ahli BNN disebut ASESMEN.',
  ),
  54 => 
  array (
    'statement' => 'Kurir narkoba yang hanya bertugas mengantar paket barang terlarang bebas dari ancaman hukuman penjara.',
    'is_fakta' => false,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'Dalam hukum pidana Indonesia, kurir dianggap sebagai bagian dari permufakatan jahat peredaran narkotika dan tetap dijatuhi hukuman penjara yang sangat berat hingga belasan tahun.',
    'clue' => 'Orang suruhan jaringan sindikat yang dimanfaatkan untuk mengantarkan narkoba disebut KURIR.',
  ),
  55 => 
  array (
    'statement' => 'Badan Narkotika Nasional (BNN) adalah lembaga pemerintah non-kementerian yang bertugas memimpin gerakan P4GN di Indonesia.',
    'is_fakta' => true,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'BNN bertugas melaksanakan pencegahan, pemberantasan penyalahgunaan dan peredaran gelap narkotika, psikotropika, prekursor, serta zat adiktif lainnya secara terpadu di seluruh tanah air.',
    'clue' => 'Istilah payung resmi undang-undang untuk seluruh zat bius terlarang adalah NARKOTIKA.',
  ),
  56 => 
  array (
    'statement' => 'Menyimpan atau menyembunyikan narkotika milik teman di dalam kamar kos terbebas dari jerat hukum pidana.',
    'is_fakta' => false,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'Pasal 111 dan 112 UU Narkotika menegaskan bahwa setiap orang yang tanpa hak menanam, memelihara, memiliki, menyimpan, atau menguasai narkotika dapat dipidana penjara minimal 4 tahun.',
    'clue' => 'Ruang sempit berjeruji besi tempat penahanan para pelaku tindak pidana narkoba adalah SEL.',
  ),
  57 => 
  array (
    'statement' => 'Pendekatan penegakan hukum terhadap penyalah guna narkotika kini mengedepankan keadilan restoratif (restorative justice).',
    'is_fakta' => true,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'Paradigma modern memandang korban penyalahguna sebagai orang sakit yang wajib disembuhkan lewat rehabilitasi, sedangkan hukuman pidana seberat-beratnya ditargetkan kepada bandar dan pengedar.',
    'clue' => 'Subjek hukum korban yang mengonsumsi zat tanpa hak dan wajib diselamatkan disebut PENYALAHGUNA.',
  ),
  58 => 
  array (
    'statement' => 'Petugas BNN berwenang melakukan razia, pemeriksaan tes urin, dan penyidikan terhadap jaringan peredaran gelap narkotika.',
    'is_fakta' => true,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'Undang-undang memberikan kewenangan penuh kepada penyidik BNN untuk melakukan penyadapan, penggeledahan, penangkapan, dan penyitaan aset kekayaan hasil tindak pidana pencucian uang narkoba.',
    'clue' => 'Strategi penindakan hukum tegas tanpa kompromi terhadap sindikat narkotika adalah REPRESIF.',
  ),
  59 => 
  array (
    'statement' => 'Pelaku kejahatan narkotika yang mengulangi perbuatannya setelah keluar dari penjara disebut sebagai residivis.',
    'is_fakta' => true,
    'badge' => 'Hukum & Regulasi P4GN',
    'explanation' => 'Residivis narkotika kerap dijatuhi hukuman yang lebih berat oleh majelis hakim karena dinilai tidak memiliki itikad baik untuk berubah dan kembali terjerat dalam kejahatan terorganisir.',
    'clue' => 'Pelaku kejahatan berulang yang kembali terjerat kasus tindak pidana narkotika disebut RESIDIVIS.',
  ),
  60 => 
  array (
    'statement' => 'Layanan rehabilitasi rawat jalan dan rawat inap di klinik BNN disediakan secara gratis bagi korban penyalahgunaan.',
    'is_fakta' => true,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'Pemerintah melalui BNN mengalokasikan anggaran negara untuk layanan rehabilitasi medis dan pascarehabilitasi agar seluruh lapisan masyarakat tanpa memandang status ekonomi dapat pulih seutuhnya.',
    'clue' => 'Kondisi keberhasilan mantan pecandu terbebas dari adiksi dan hidup produktif adalah PULIH.',
  ),
  61 => 
  array (
    'statement' => 'Rehabilitasi medis hanya memberikan obat tidur agar pecandu terus tertidur selama masa penyembuhan.',
    'is_fakta' => false,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'Rehabilitasi medis melibatkan penanganan komprehensif dokter, psikiater, dan perawat untuk detoksifikasi aman, penyembuhan komplikasi fisik, serta pemulihan fungsi kognitif otak.',
    'clue' => 'Intervensi klinis terstruktur untuk memulihkan raga dan jiwa mantan pecandu disebut TERAPI.',
  ),
  62 => 
  array (
    'statement' => 'Balai Besar Rehabilitasi BNN yang berlokasi di Lido Bogor merupakan pusat rehabilitasi narkoba terbesar di Indonesia.',
    'is_fakta' => true,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'Balai Besar Rehabilitasi Lido Bogor menyediakan fasilitas medis dan vokasional terakreditasi internasional yang telah meluluskan ribuan mantan pecandu kembali berkarya di masyarakat.',
    'clue' => 'Nama kota lokasi Balai Besar Rehabilitasi Narkotika rujukan nasional BNN adalah BOGOR.',
  ),
  63 => 
  array (
    'statement' => 'Konseling psikologis adiksi membantu mantan pecandu mengidentifikasi pemicu (triggers) dan mencegah kekambuhan.',
    'is_fakta' => true,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'Melalui konseling Cognitive Behavioral Therapy (CBT), pasien dilatih mengenali situasi berisiko tinggi, mengendalikan dorongan sakaw psikologis, dan membangun keterampilan hidup baru.',
    'clue' => 'Sesi wawancara tatap muka bersama tenaga konselor adiksi untuk memetakan pemulihan disebut KONSUL.',
  ),
  64 => 
  array (
    'statement' => 'Dukungan penuh keluarga sangat menentukan tingkat keberhasilan pemulihan seorang mantan pecandu narkoba.',
    'is_fakta' => true,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'Keluarga yang menerima tanpa menghakimi dan menciptakan lingkungan rumah yang harmonis menurunkan risiko relaps hingga lebih dari 70% dibanding pasien yang diasingkan.',
    'clue' => 'Menghilangkan prasangka negatif dan diskriminasi di masyarakat adalah membasmi STIGMA.',
  ),
  65 => 
  array (
    'statement' => 'Setelah selesai menjalani masa rehabilitasi medis, mantan pecandu tidak memerlukan pendampingan pascarehabilitasi lagi.',
    'is_fakta' => false,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'Program pascarehabilitasi sangat krusial untuk melatih kemandirian ekonomi, pencegahan kekambuhan sosial, dan reintegrasi mantan pecandu ke dalam lingkungan kerja secara aman.',
    'clue' => 'Tenaga pendamping ahli profesional yang membimbing pemulihan pasien narkoba disebut KONSULTAN.',
  ),
  66 => 
  array (
    'statement' => 'Pecandu yang menjalani rehabilitasi dilatih keterampilan kerja (vokasional) agar siap berwirausaha secara mandiri.',
    'is_fakta' => true,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'BNN membekali pasien dengan keahlian komputer, otomotif, tata boga, dan kerajinan tangan agar memiliki kemandirian finansial dan tidak kembali tergiur rayuan sindikat narkoba.',
    'clue' => 'Kehidupan baru yang terbebas seutuhnya dari lingkaran hitam narkotika adalah hidup BEBAS.',
  ),
  67 => 
  array (
    'statement' => 'Pemeriksaan sampel urin rutin selama masa rehabilitasi bertujuan untuk memantau integritas pemulihan pasien.',
    'is_fakta' => true,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'Tes urin berkala memberikan data objektif bahwa tubuh pasien bersih dari racun zat dan membantu tim konselor memberikan apresiasi atas kemajuan pemulihannya.',
    'clue' => 'Sampel cairan tubuh utama yang digunakan dalam pemeriksaan uji tapis narkotika adalah URIN.',
  ),
  68 => 
  array (
    'statement' => 'Rehabilitasi sosial menggunakan pendekatan Therapeutic Community (TC) di mana sesama residen saling menguatkan.',
    'is_fakta' => true,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'Metode TC menumbuhkan rasa persaudaraan, kejujuran emosional, dan disiplin tinggi melalui interaksi kelompok terstruktur tanpa kekerasan.',
    'clue' => 'Karakter batin yang ditanamkan untuk saling menolong dan berbuat kebajikan adalah MORAL.',
  ),
  69 => 
  array (
    'statement' => 'Pecandu narkoba dapat disembuhkan hanya dalam waktu 24 jam dengan menggunakan terapi hipnotis kilat.',
    'is_fakta' => false,
    'badge' => 'Rehabilitasi & Pemulihan',
    'explanation' => 'Tidak ada terapi instan untuk adiksi. Mengubah jalur saraf otak yang rusak dan pola perilaku menuntut tahapan medis teratur yang memakan waktu minimal 3 hingga 6 bulan.',
    'clue' => 'Sifat kambuhan alami dari penyakit adiksi yang harus selalu diwaspadai disebut RESIDIF.',
  ),
  70 => 
  array (
    'statement' => 'Narkotika hanya merusak sistem saraf otak dan tidak menimbulkan efek buruk pada organ jantung manusia.',
    'is_fakta' => false,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Semua jenis stimulan memaksa otot jantung bekerja sangat keras, menyebabkan aritmia mematikan, hipertensi krisis, serangan jantung akut, hingga robeknya pembuluh aorta.',
    'clue' => 'Zat beracun berbahaya di dalam narkoba yang merusak organ vital manusia adalah RACUN.',
  ),
  71 => 
  array (
    'statement' => 'Penyalahgunaan narkoba suntik berulang kali dapat merusak katup jantung akibat infeksi bakteri endokarditis.',
    'is_fakta' => true,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Bakteri dari jarum kotor atau kulit masuk langsung ke aliran darah dan bersarang di katup jantung, menyebabkan kebocoran katup dan gagal jantung fatal pada usia muda.',
    'clue' => 'Cara konsumsi obat cair yang disuntikkan langsung ke dalam pembuluh darah adalah SUNTIK.',
  ),
  72 => 
  array (
    'statement' => 'Konsumsi narkoba jangka panjang dapat memicu gagal ginjal kronis yang mengharuskan pasien cuci darah seumur hidup.',
    'is_fakta' => true,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Zat kimia toksik narkoba dan kondisi rhabdomyolysis (hancurnya serat otot akibat kejang atau dehidrasi sabu/ekstasi) menyumbat tubulus ginjal hingga ginjal mati permanen.',
    'clue' => 'Cairan tubuh pengalir nutrisi dan sisa metabolit racun ke seluruh organ adalah DARAH.',
  ),
  73 => 
  array (
    'statement' => 'Pengguna narkoba suntik memiliki risiko terpapar virus Hepatitis B dan C puluhan kali lipat lebih tinggi dari populasi umum.',
    'is_fakta' => true,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Virus hepatitis ditularkan sangat mudah melalui mikrodarah yang tersisa pada rongga jarum suntik, yang kemudian memicu sirosis hati dan kanker hati ganas.',
    'clue' => 'Benda tajam pemakaian bersama pemicu utama penularan infeksi mematikan adalah JARUM.',
  ),
  74 => 
  array (
    'statement' => 'Organ hati (lever) manusia mampu menetralisir racun narkoba tanpa mengalami peradangan atau kerusakan sama sekali.',
    'is_fakta' => false,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Hati bekerja ekstra keras menyaring racun kimia narkotika. Beban berlebih ini memicu peradangan sel hepatosit, perlemakan hati toksik, hingga sirosis permanen.',
    'clue' => 'Sifat daya racun senyawa kimia narkotika yang mematikan sel-sel organ tubuh disebut TOKSIK.',
  ),
  75 => 
  array (
    'statement' => 'Pemakaian narkoba dosis tinggi memicu kondisi spasme otot hebat dan kram menyiksa di sekujur tubuh.',
    'is_fakta' => true,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Ketidakseimbangan elektrolit akut dan gangguan impuls saraf akibat obat memicu kram otot ekstrem yang sangat menyakitkan pada betis, punggung, dan perut.',
    'clue' => 'Kejang dan kontraksi otot menyakitkan yang kerap melanda tubuh pecandu adalah KRAM.',
  ),
  76 => 
  array (
    'statement' => 'Zat narkoba inhalan (lem dan solven) dapat melarutkan selaput pelindung saraf dan memicu kerusakan sumsum tulang belakang.',
    'is_fakta' => true,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Uap kimia benzena dan toluena merusak sumsum tulang tempat produksi sel darah merah, menyebabkan anemia aplastik mematikan dan kelumpuhan saraf tepi permanen.',
    'clue' => 'Sifat zat beracun perusak sel neuron dan jaringan saraf otak disebut NEUROTOKSIK.',
  ),
  77 => 
  array (
    'statement' => 'Kekebalan tubuh (sistem imun) pecandu narkoba menurun drastis sehingga mereka sangat rentan terinfeksi tuberkulosis (TBC).',
    'is_fakta' => true,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Narkotika menekan produksi sel darah putih (leukosit) dan merusak nutrisi tubuh, membuat penderita sangat mudah terserang infeksi paru TBC dan pneumonia berat.',
    'clue' => 'Kondisi penurunan kesehatan jasmani dan ringkihnya raga manusia disebut rusaknya BADAN.',
  ),
  78 => 
  array (
    'statement' => 'Minum air kelapa muda hangat sesaat sebelum tes urin dapat mengubah urine menjadi jernih dan bebas dari metabolit narkoba.',
    'is_fakta' => false,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Alat rapid test laboratorium mendeteksi metabolit kimia spesifik narkoba yang dikeluarkan lewat ginjal. Air kelapa tidak dapat menghapus jejak metabolit yang sudah mengendap.',
    'clue' => 'Cairan ekskresi tubuh yang menjadi bahan uji skrining narkoba adalah URIN.',
  ),
  79 => 
  array (
    'statement' => 'Penyalahgunaan obat jenis ekstasi dapat memicu dehidrasi parah yang berujung pada kegagalan multi-organ mematikan.',
    'is_fakta' => true,
    'badge' => 'Kerusakan Fisik & Organ',
    'explanation' => 'Peningkatan metabolisme tubuh tanpa diimbangi cairan memicu dehidrasi hipertermia di mana suhu organ dalam tubuh mencapai 42°C hingga darah membeku di pembuluh.',
    'clue' => 'Bahan padat obat penenang dan stimulan yang diedarkan bandar di pesta malam adalah PIL.',
  ),
  80 => 
  array (
    'statement' => 'Penggunaan narkoba dapat memicu halusinasi auditori berupa suara-suara bisikan gaib yang memerintahkan tindak kekerasan.',
    'is_fakta' => true,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Kerusakan reseptor dopamin dan serotonin mengacaukan korteks pendengaran otak sehingga penderita mendengar suara ancaman semu yang tampak sangat nyata baginya.',
    'clue' => 'Gejala gangguan persepsi semu melihat atau mendengar tanpa stimulus nyata disebut HALUSINASI.',
  ),
  81 => 
  array (
    'statement' => 'Narkoba adalah solusi efektif untuk menghilangkan stres pikiran dan menyembuhkan trauma masa lalu secara permanen.',
    'is_fakta' => false,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Narkoba hanyalah pelarian semu sesaat yang justru memperparah trauma. Saat efek zat hilang, otak mengalami depresi yang jauh lebih dalam disertai kecanduan yang merusak hidup.',
    'clue' => 'Gangguan kejiwaan berupa keputusasaan mendalam akibat terkurasnya hormon otak disebut DEPRESI.',
  ),
  82 => 
  array (
    'statement' => 'Pecandu narkoba kerap mengurung diri dan menarik diri dari pergaulan sosial positif (isolasi sosial).',
    'is_fakta' => true,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Rasa bersalah, paranoia takut tertangkap aparat, dan hilangnya minat pada hobi membuat pemakai mengisolasi diri di kamar dan hanya bergaul dengan sesama pengguna.',
    'clue' => 'Kecenderungan pecandu menjauhkan diri dari keluarga dan dunia luar disebut ISOLASI.',
  ),
  83 => 
  array (
    'statement' => 'Kondisi putus obat (sakaw) pada pengguna obat penenang dapat memicu serangan panik dan kecemasan ekstrem.',
    'is_fakta' => true,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Karena reseptor GABA otak terbiasa ditekan oleh zat penenang, penghentian tiba-tiba membuat sistem saraf pusat mengalami badai lonjakan impuls panik tak terkendali.',
    'clue' => 'Kumpulan tanda dan gejala medis komplikasi yang menyertai putus zat disebut SINDROM.',
  ),
  84 => 
  array (
    'statement' => 'Halusinogen seperti jamur tahi sapi (magic mushroom) tergolong narkotika alami yang sepenuhnya aman bagi kesehatan jiwa.',
    'is_fakta' => false,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Magic mushroom mengandung psilosibin terlarang golongan I yang memicu gangguan kejiwaan akut (bad trip), disorientasi ruang-waktu parah, dan risiko bunuh diri mendadak.',
    'clue' => 'Golongan zat yang memicu kekacauan persepsi realitas panca indera disebut HALUSINOGEN.',
  ),
  85 => 
  array (
    'statement' => 'Pecandu narkoba yang mengalami psikosis berat dapat kehilangan kontak seutuhnya dengan kenyataan hidup nyata.',
    'is_fakta' => true,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Kerusakan biokimiawi otak membuat penderita tidak mampu lagi membedakan antara khayalan semu dan kenyataan objektif, meracau tak tentu arah, dan membahayakan lingkungan sekitar.',
    'clue' => 'Kondisi gangguan jiwa parah akibat rusaknya jalur nalar dan persepsi otak disebut PSIKOSIS.',
  ),
  86 => 
  array (
    'statement' => 'Kehilangan kendali kesadaran akibat mabuk zat narkotika kerap menjadi pemicu tindak pelecehan dan kekerasan seksual.',
    'is_fakta' => true,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Zat psikoaktif melumpuhkan fungsi inhibisi moral otak. Dalam kondisi teler dan hilang akal sehat, pemakai sangat mudah melakukan tindakan asusila dan kriminalitas keji.',
    'clue' => 'Fungsi luhur akal budi dan kontrol diri yang terenggut saat terbius zat adalah KESADARAN.',
  ),
  87 => 
  array (
    'statement' => 'Ketagihan narkoba semata-mata adalah masalah kurangnya kemauan keras dan tidak melibatkan dorongan kimiawi biologis.',
    'is_fakta' => false,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Adiksi melibatkan pembajakan jalur dopaminergik di nucleus accumbens. Otak pecandu mengirimkan sinyal rasa lapar biologis palsu yang menuntut zat sama kuatnya dengan dorongan mencari air saat kehausan.',
    'clue' => 'Hasrat emosional kompulsif mencari dan mengonsumsi zat kembali disebut KETAGIHAN.',
  ),
  88 => 
  array (
    'statement' => 'Delirium adalah kondisi gangguan mental akut berupa kebingungan parah dan disorientasi hebat akibat keracunan zat.',
    'is_fakta' => true,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Kondisi gawat darurat psikiatri ini kerap terjadi pada overdosis atau putus zat alkohol/sedatif berat, di mana penderita meronta-ronta, mengigau hebat, dan tidak mengenali keluarganya.',
    'clue' => 'Gangguan kognitif akut berupa kebingungan ekstrem dan disorientasi hebat disebut DELIRIUM.',
  ),
  89 => 
  array (
    'statement' => 'Keseimbangan reaksi kimiawi neurotransmitter otak dapat hancur berantakan akibat pengaruh zat psikoaktif terlarang.',
    'is_fakta' => true,
    'badge' => 'Kesehatan Mental & Psikosis',
    'explanation' => 'Zat narkoba merusak regulasi serotonin, dopamin, noradrenalin, dan GABA, menghancurkan homeostasis kimiawi otak dan memicu gangguan mood bipolar seumur hidup.',
    'clue' => 'Keseimbangan proses molekuler dan reaksi kimiawi dalam tubuh manusia disebut BIOKIMIA.',
  ),
  90 => 
  array (
    'statement' => 'Program Desa Bersinar (Bersih Narkoba) adalah salah satu strategi unggulan BNN membentengi masyarakat pedesaan.',
    'is_fakta' => true,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'Desa Bersinar memberdayakan kepala desa, tokoh agama, pemuda, dan babinsa untuk membentuk relawan pencegahan dan deteksi dini guna menangkal penetrasi sindikat narkoba ke pelosok.',
    'clue' => 'Masyarakat peduli yang aktif mengedukasi warga tentang bahaya narkoba disebut RELAWAN.',
  ),
  91 => 
  array (
    'statement' => 'Menolak tawaran mencoba narkoba dari teman sebaya dengan tegas dan asertif adalah tanda sikap pengecut.',
    'is_fakta' => false,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'Berani berkata TIDAK pada narkoba adalah bukti kecerdasan emosional, ketahanan diri (resilience), dan integritas karakter pemimpin sejati yang memiliki visi masa depan cemerlang.',
    'clue' => 'Integritas budi pekerti dan prinsip batin kuat generasi muda disebut MORAL.',
  ),
  92 => 
  array (
    'statement' => 'Skrining tes urin acak di lingkungan sekolah dan kampus bertujuan untuk mendiskriminasi dan mempermalukan siswa.',
    'is_fakta' => false,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'Tes urin deteksi dini di sekolah bertujuan preventif untuk melindungi lingkungan pendidikan dari penyusupan bandar dan memastikan siswa yang terindikasi segera mendapatkan intervensi rehabilitasi.',
    'clue' => 'Uji tapis pendahuluan untuk mendeteksi zat narkoba dalam tubuh seseorang disebut SKRINING.',
  ),
  93 => 
  array (
    'statement' => 'Rokok konvensional dan rokok elektrik (vape) sering menjadi pintu gerbang awal (gateway drug) menuju penyalahgunaan narkotika.',
    'is_fakta' => true,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'Nikotin membiasakan reseptor otak pada kepuasan kimiawi instan. Remaja yang merokok memiliki probabilitas terjerumus narkoba sabu dan ganja jauh lebih tinggi dibanding non-perokok.',
    'clue' => 'Zat adiktif stimulan utama yang terkandung dalam daun tembakau adalah NIKOTIN.',
  ),
  94 => 
  array (
    'statement' => 'Membangun komunikasi terbuka dan hangat di dalam keluarga menjadi benteng perlindungan terkuat anak dari pengaruh buruk narkoba.',
    'is_fakta' => true,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'Keluarga yang harmonis di mana anak merasa didengar dan dihargai membuat mereka tidak mencari pelarian semu ke kelompok pergaulan menyimpang dan lingkaran sindikat narkoba.',
    'clue' => 'Langkah pencegahan mengenali bahaya narkotika di lingkungan sekitar disebut DETEKSI.',
  ),
  95 => 
  array (
    'statement' => 'Mengonsumsi narkoba adalah hak asasi pribadi yang bebas dilakukan oleh siapa saja tanpa boleh diintervensi oleh negara.',
    'is_fakta' => false,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'Penyalahgunaan narkoba adalah kejahatan transnasional yang merusak ketahanan nasional, memicu tindak kriminalitas, dan menghancurkan masa depan peradaban bangsa sehingga wajib diberantas tuntas.',
    'clue' => 'Ancaman kerusakan nyata terhadap raga, jiwa, dan tatanan masyarakat adalah BAHAYA.',
  ),
  96 => 
  array (
    'statement' => 'Program Remaja Teman Sebaya BNN melatih anak muda menjadi agen perubahan anti-narkoba di lingkungannya.',
    'is_fakta' => true,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'Anak muda dilatih mengenali modus penipuan kurir narkoba, mengasah kemampuan menolak bujukan negatif, dan mengajak kawan sebayanya berprestasi lewat aktivitas olahraga dan seni.',
    'clue' => 'Langkah strategis pembinaan sistematis pencegahan bahaya narkotika disebut PREVENTIF.',
  ),
  97 => 
  array (
    'statement' => 'Setiap warga negara memiliki hak dan kewajiban hukum untuk melaporkan dugaan peredaran gelap narkoba di sekitarnya ke BNN.',
    'is_fakta' => true,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'UU No. 35 Tahun 2009 Pasal 104 menjamin peran serta masyarakat dalam P4GN serta memberikan perlindungan hukum penuh dan kerahasiaan identitas bagi saksi pelapor.',
    'clue' => 'Tanda-tanda mencurigakan dan perubahan perilaku pemakai narkoba disebut GEJALA.',
  ),
  98 => 
  array (
    'statement' => 'Kecanduan game online dan gawai tidak memiliki kaitan sama sekali dengan kerentanan otak terhadap narkotika.',
    'is_fakta' => false,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'Adiksi digital melatih otak terbiasa dengan lonjakan dopamin cepat tanpa usaha keras. Pola sirkuit penghargaan yang terbiasa instan ini membuat remaja lebih rentan terjerat zat adiktif kimiawi.',
    'clue' => 'Pendekatan menyeluruh berbasis ketahanan lingkungan demi pencegahan narkoba adalah PREVENSIONAL.',
  ),
  99 => 
  array (
    'statement' => 'Generasi muda yang bersih dari narkoba memiliki peluang jauh lebih besar untuk meraih karier sukses dan masa depan gemilang.',
    'is_fakta' => true,
    'badge' => 'Pencegahan Dini & P4GN',
    'explanation' => 'Tanpa beban adiksi dan rekam jejak kriminal, fisik dan pikiran tetap prima untuk berinovasi, berprestasi di kancah nasional maupun dunia, dan membanggakan keluarga serta bangsa.',
    'clue' => 'Merdeka dari belenggu kecanduan dan bebas berkarya menggapai cita-cita adalah hidup BEBAS.',
  ),
);

        foreach ($questions as $item) {
            GameMitosFakta::create([
                'statement' => $item['statement'],
                'is_fakta' => (bool) $item['is_fakta'],
                'badge' => $item['badge'],
                'explanation' => $item['explanation'],
                'clue' => $item['clue'],
                'is_active' => true,
            ]);
        }
    }
}
